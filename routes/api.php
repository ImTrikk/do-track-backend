<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CollegeController;
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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // attendance api routes
    Route::controller(AttendanceController::class)->group(function () {

        // api route for time_in and time_out of students
        Route::post('/attendance/record-time', 'RecordTime');

        // api route for getting the 
        Route::get('/attendance/college-info/{id}', 'getCollegeInfo');

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
        Route::get('/attendance/get-student-attendees/{id}', 'getStudentAttendees');

        // get all scanned students by a specific admin
        Route::get('/attendance/get-scanned-by-admin/{id}', "getScannedByAdmin");

        // delete student attendance record
        Route::delete('/attendance/delete-student-record/{id}', 'deleteStudentAttendanceRecord');

        // api for finding student_id
        Route::get('/attendance/find-student/{id}', 'findStudentId');
    });


    // route api for CollegeController
    Route::controller(CollegeController::class)->group(function () {
        // gets all the program information in college
        Route::get('/college/get-programs-college/{id}', 'getProgramsByCollege');
    });
});
