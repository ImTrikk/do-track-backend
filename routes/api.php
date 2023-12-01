<?php

use Illuminate\Support\Facades\Route;

//controllers
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//APIs for Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

//APIs for Attendance management (Provide down below)
//Apply middleware for authentication
//Create a controller for Attendance management

// Route::middleware('auth:sanctum')
//     ->controller(AttendanceController::class)
//     ->group(['prefix' => 'attendance'], function () {
//         //Routes here
//         //example
//         //Route::get('/attendance, 'allAttendances');
//     });
