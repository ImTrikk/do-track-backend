<?php

namespace App\Http\Controllers\Api;

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
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:8',
            'admin_id' => 'required|exists:admins,admin_id',
            'first_name' => 'required|exists:admins,first_name',
            'last_name' => 'required|exists:admins,last_name',
            'password' => 'required|exists:admins,password|min:12',
            'college_id' => 'required|exists:admins,college_id',
            'position' => 'required|exists:admins,position',
        ]);

        $admin = Admins::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin_id' => $request->admin_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'college_id' => $request->college_id,
        ]);

        if ($admin->save()) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Admin created successfully',
                    'data' => $admin,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Admin not created',
                ],
                401
            );
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
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

        $password = request(['email', 'password']);

        if (
            !Auth::attempt($password) ||
            !Hash::check($request->password, $admin->password)
        ) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid password. Please try again.',
                ],
                401
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
