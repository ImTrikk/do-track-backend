<?php

use App\Http\Controllers\Api\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// attendance api routes
Route::controller(AttendanceController::class)->group(function () {
    Route::post('/attendance/time_in', 'timeIn');
    Route::post('/attendance/time_out', 'timeOut');
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
});