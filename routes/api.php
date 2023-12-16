<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Models\Students;
use Illuminate\Http\Request;
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

// header('Access-Control-Allow-Origin: https://do-track.vercel.app');

//APIs for Authentication
// Route::group(['prefix' => 'auth'], function () { 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
// });

// attendance api routes
Route::controller(AttendanceController::class)->group(function () {

    // api route for tiem_in and time_out of students
    Route::post('/attendance/record-time', 'RecordTime');

    // api route for getting the 
    Route::get('/attendance/college-info', 'getCollegeInfo');

    // api router for getting the students, filtered by college_id
    Route::get('/attendance/attendance-by-college/{id}', 'getAttendanceByCollege');

    // api router for getting the students, filtered by program_id
    Route::get('/attendance/attendance-by-program/{id}', 'getAttendanceByProgram');

    // api router for getting the students with completed rendered hours  (3hours)
    Route::get('/attendance/attendance-by-rendered-hours', 'getAttendanceByRenderedHour');

    // api router for getting the students with completed rendered hours  (3hours), filteered with college_id
    Route::get('/attendance/attendance-by-rendered-hours-college/{id}', 'getAttendanceByRenderedHourWithCollege');

    // api router for getting the students with no time_in and time_out
    Route::get('/attendance/attendance-by-no-timestamps/{id}', 'getStudentNoTimeInOut');

    // api route for atendees
    Route::get('/attendance/getStudentAttendees/{id}', 'getStudentAttendees');
});
