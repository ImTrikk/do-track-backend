<?php

namespace App\Http\Controllers\Api;


use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admins;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::unique('admins')],
            'password' => 'required|min:8',
            'admin_id' => ['required', Rule::unique('admins')],
            'first_name' => 'required',
            'last_name' => 'required',
            'college_id' => 'required',
            'position' => 'required',
        ]);

        $admin = Admins::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin_id' => $request->admin_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'college_id' => $request->college_id,
            'position' => $request->position
        ]);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Admin created successfully',
                'data' => $admin,
            ],
            201
        );
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $admin = Admins::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Admin not found',
                ],
                401
            );
        }

        $credentials = request(['email', 'password']);

        if (
            !Auth::attempt($credentials)
        ) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid password. Please try again.',
                ],
                403
            );
        }


        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'message' => 'Login successful',
                'data' => [
                    'admin' => $admin,
                    'token' => $token,
                ],
            ],
            200
        );
    }

    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logged out successfully',
            ],
            200
        );
    }
}
