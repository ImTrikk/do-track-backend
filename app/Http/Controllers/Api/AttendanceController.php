<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequests;
use App\Models\Admins;
use App\Models\Attendances;
use App\Models\Students;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    // find college by colleges
    public function getAttendanceByCollege(string $id)
    {
        // Use DB::table for a query builder instance
        $response = DB::table('attendances')
            ->select(
                'students.student_id',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'attendances.time_in',
                'attendances.time_out',
                'attendances.total_hours',
                'programs.program_name',
                'students.year_level_code',
                'colleges.college_name',
                'admins.first_name as admin_first_name',
                'admins.last_name as admin_last_name'
            )
            ->join('admins', 'admins.admin_id', '=', 'attendances.admin_id')
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->join('colleges', 'colleges.college_id', '=', 'programs.college_id')
            ->where('colleges.college_id', '=', $id)
            ->get();

        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No attendance records found for the given college ID'
                ],
                404
            );
        }

        // Return the results
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Retrieved attendance information by college',
                'data' => $response
            ],
            200
        );
    }


    // display attendances by program
    public function getAttendanceByProgram(string $id)
    {
        // Use DB::table for a query builder instance
        $response = DB::table('attendances')
            ->select(
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'attendances.time_in',
                'attendances.time_out',
                'attendances.total_hours',
                'programs.program_name',
                'admins.first_name as admin_first_name',
                'admins.last_name as admin_last_name',
            )
            ->join('admins', 'admins.admin_id', '=', 'attendances.admin_id')
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('programs.program_id', '=', $id)
            ->get();

        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No attendance records found for the given program ID'
                ],
                404
            );
        }

        // Return the results
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Retrieved attendance information by program',
                'data' => $response
            ],
            200
        );
    }
    //getting the attendance data by filtering total_hours as rendered hours for equal or more than 3 hours 
    public function getAttendanceByRenderedHour()
    {
        $response = DB::table('attendances')
            ->select(
                'students.student_id',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'attendances.time_in',
                'attendances.time_out',
                'attendances.total_hours',
                'programs.program_name',
                'admins.first_name as admin_first_name',
                'admins.last_name as admin_last_name',
            )
            ->join('admins', 'admins.admin_id', '=', 'attendances.admin_id')
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('attendances.total_hours', '>=', 3.00)
            ->get();
        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No attendance records found for students who rendered more than 3 hours'
                ],
                404
            );
        }
        // Return the results
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Retrieved students who rendered more than 3 hours',
                'data' => $response
            ],
            200
        );
    }
    // retrieving students with total rendered hourse is equal or more than 3 hours
    //filtered by college_id
    public function getAttendanceByRenderedHourWithCollege(string $id)
    {
        $response = DB::table('attendances')
            ->select(
                'students.student_id',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'attendances.time_in',
                'attendances.time_out',
                'attendances.total_hours',
                'programs.program_name',
                'colleges.college_name',
                'admins.first_name as admin_first_name',
                'admins.first_name as admin_last_name',
            )
            ->join('admins', 'admins.admin_id', '=', 'attendances.admin_id')
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->join('colleges', 'colleges.college_id', '=', 'programs.college_id')
            ->where('attendances.total_hours', '>=', 3.00, 'and', 'colleges.college_id', '=', $id)
            ->get();

        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No attendance records found for students who rendered more than 3 hours'
                ],
                404
            );
        }

        // Return the results
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Retrieved students who rendered more than 3 hours',
                'data' => $response
            ],
            200
        );
    }


    //controller for getting the students with no time_in and time_out
    // filtered using college_id
    public function getStudentNoTimeInOut(string $id)
    {
        $response = DB::table('attendances')
            ->select(
                'students.student_id',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'attendances.time_in',
                'attendances.time_out',
                'attendances.total_hours',
                'programs.program_name',
                'colleges.college_name'
            )
            ->join('students', 'attendances.student_id', '=', 'students.student_id')
            ->join('programs', 'students.program_id', '=', 'programs.program_id')
            ->join('colleges', 'programs.college_id', '=', 'colleges.college_id')
            ->where(function ($query) {
                $query->whereNull('attendances.time_in')
                    ->orWhereNull('attendances.time_out');
            })
            ->get();

        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No attendance records found for students who do not have time_in or time_out'
                ],
                404
            );
        }

        // Return the results
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Retrieved students who do not have time_in and/or time_out',
                'data' => $response
            ],
            200
        );
    }

    // time_in and time_out functionality
    public function RecordTime(Request $request)
    {
        $admin_id = $request->admin_id;
        $student_id = $request->student_id;

        // Check if student_id exists in the students table
        $studentExists = Students::where('student_id', $student_id)->exists();

        if (!$studentExists) {
            return response()->json(['status' => 'error', 'message' => 'Student not found'], 404);
        }

        // Check if student_id exists in the admins table
        $adminExists = Admins::where('admin_id', $student_id)->exists();

        if ($adminExists) {
            return response()->json(['status' => 'error', 'message' => 'Scanned ID is an admin_id'], 403);
        }

        // Check if time_in is null
        $attendance = Attendances::where('student_id', $student_id)
            ->first();

        if (!$attendance || is_null($attendance->time_in)) {
            // Logic for recording time_in
            $attendance = Attendances::updateOrCreate(
                ['admin_id' => $admin_id, 'student_id' => $student_id],
                [
                    'time_in' => now()->tz('Asia/Manila')->format('Y-m-d H:i:s'), // Set to Philippine Time
                    'date' => now()->tz('Asia/Manila')->format('Y-m-d H:i:s'),   // Set
                    'total_hours' => 0,
                    'required_hours' => 3
                ] // Set a default value for total_hours
            );

            return response()->json(['message' => 'Time in recorded successfully', 'attendance' => $attendance]);
        } else {
            // Check if the attendance was recorded by another admin
            if ($attendance->admin_id != $admin_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Another admin has recorded the student\'s attendance'
                ], 403);
            }

            // Logic for recording time_out
            if ($attendance->time_in && is_null($attendance->time_out)) {
                // Update time_out and calculate total hours
                // $attendance->time_out = now()->tz('Asia/Manila')->addHours(5)->format('Y-m-d H:i:s');
                $attendance->time_out = now()->tz('Asia/Manila')->format('Y-m-d H:i:s');

                $timeIn = Carbon::parse($attendance->time_in)->tz('Asia/Manila');
                $timeOut = Carbon::parse($attendance->time_out)->tz('Asia/Manila'); // Ensure both use the same timezone

                // Calculate the difference in hours directly
                $hoursDifference = $timeIn->diffInHours($timeOut);

                // Update total_hours in the database (using hours as a decimal)
                $attendance->total_hours = $hoursDifference;
                $attendance->save();
                return response()->json(['message' => 'Time out recorded successfully', 'attendance' => $attendance]);
            } else {
                return response()->json(['message' => 'Time out already recorded for this attendance'], 403);
            }
        }
    }


    //retrieve attendences by program   
    public function getStudentAttendees(string $id)
    {
        $response = DB::table('attendances')
            ->select(
                'students.student_id',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'attendances.time_in',
                'attendances.time_out',
                'attendances.total_hours',
                'programs.program_name',
                'year_levels.year_level_code',
                'admins.first_name as admin_first_name',
                'admins.last_name as admin_last_name'
            )
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('year_levels', 'year_levels.year_level_code', '=', 'students.year_level_code')
            ->join('admins', 'admins.admin_id', '=', 'attendances.admin_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('programs.program_id', '=', $id)
            ->where('time_in', '!=', NULL)
            ->where('time_out', '!=', NULL)
            ->get();

        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => "No attendances in the program: $id"
                ],
                404
            );
        }

        // Return the results
        return response()->json(
            [
                'status' => 'success',
                'message' => "Retrieved student attendances in the program: $id",
                'data' => $response
            ],
            200
        );
    }

    public function getCollegeInfo(string $id)
    {

        // Query to count all students and return all students
        // Query to count total students in the specified program
        $totalStudents = DB::table('students')
            ->select(DB::raw('count(students.student_id) as total_population'))
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('programs.program_id', '=', $id)
            ->get();

        // Query to count attendees with a total_hours condition
        $attendees = DB::table('students')
            ->select(DB::raw('count(DISTINCT attendances.student_id) as attendees_count'))
            ->join('attendances', 'attendances.student_id', '=', 'students.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('attendances.total_hours', '>=', 3)
            ->where('programs.program_id', '=', $id)
            ->get();

        $program_name = DB::table('students')
            ->select('programs.program_name')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('programs.program_id', '=', $id)
            ->limit(1)
            ->get();

        // Calculate the percentage
        $percentage = 0;
        if ($totalStudents->isNotEmpty() && $attendees->isNotEmpty()) {
            $totalPopulation = $totalStudents[0]->total_population;
            $attendeesCount = $attendees[0]->attendees_count;

            // Avoid division by zero
            if ($totalPopulation > 0) {
                $percentage = ($attendeesCount / $totalPopulation) * 100;
            }
        }

        return response()->json([
            'program_name' => $program_name,
            'total_students' => $totalStudents,
            'attendees' => $attendees,
            'student_percentage' => $percentage,
        ]);
    }

    public function getScannedByAdmin(string $id)
    {
        $response = DB::table('attendances')
            ->select(
                'students.first_name',
                'students.last_name',
                'attendances.time_in',
                'attendances.time_out',
                'programs.program_name',
                'year_levels.year_level_code',

            )
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('year_levels', 'year_levels.year_level_code', '=', 'students.year_level_code')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->join('admins', 'admins.admin_id', '=', 'attendances.admin_id')
            ->where('admins.admin_id', '=', $id)
            ->get();

        return response()->json(
            [
                'data' => $response
            ]
        );
    }

    public function deleteStudentAttendanceRecord(string $id)
    {
        $affectedRows = DB::table('attendances')->where('student_id', $id)->delete();

        if ($affectedRows > 0) {
            return response()->json(
                [
                    'status' => 'Student attendance record deleted'
                ], 200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error', 'message' => 'Record not found'
                ],
                404
            );
        }
    }

    // search student by student_id in attendances table
    public function findStudentId(string $id)
    {
        $response = DB::table('attendances')
            ->select(
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'students.student_id',
                'attendances.time_in',
                'attendances.time_out',
                'programs.program_id'
            )
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->where('students.student_id', '=', $id)
            ->first();


        if (empty($response)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => "Student not found in attendees"
                ],
                404,
            );
        }


        return response()->json(
            [
                'data' => $response
            ],
            200,
        );
    }
}
