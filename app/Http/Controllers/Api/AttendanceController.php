<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequests;
use App\Models\Attendances;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

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
                'colleges.college_name',
                'admins.first_name as admin_first_name',
                'admins.last_name as admin_last_name',
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

        // return the results
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
        $admin_id = $request->input('admin_id');
        $student_id = $request->input('student_id');

        // Check if time_in is null
        $attendance = Attendances::where('admin_id', $admin_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$attendance || is_null($attendance->time_in)) {
            // Logic for recording time_in
            $attendance = Attendances::updateOrCreate(
                ['admin_id' => $admin_id, 'student_id' => $student_id],
                ['time_in' => now(), ['time_in' => now(), 'total_hours' => 0, 'required_hours' => 0]] // Set a default value for total_hours
            );

            return response()->json(['message' => 'Time in recorded successfully', 'attendance' => $attendance]);
        } else {
            // Logic for recording time_out
            if (is_null($attendance->time_out)) {
                // Update time_out and calculate total hours
                $attendance->time_out = now();
                $timeIn = new \DateTime($attendance->time_in);
                $timeOut = new \DateTime($attendance->time_out);
                $interval = $timeIn->diff($timeOut);
                $totalHours = $interval->h + $interval->i / 60;

                // Update total_hours in the database
                $attendance->total_hours = $totalHours;
                $attendance->save();

                return response()->json(['message' => 'Time out recorded successfully', 'attendance' => $attendance]);
            } else {
                return response()->json(['message' => 'Time out already recorded for this attendance']);
            }
        }
    }



    //retrieve attendences by program   
    public function getStudentAttendece(string $id)
    {
        $response = DB::table('attendances')
            ->select(
                'students.student_id',
                'students.first_name',
                'students.last_name',
                'attendances.time_in',
                'attendances.time_out',
                'programs.program_name'
            )
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
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

    public function getCollegeInfo()
    {
        $response = DB::table('attendances')
            ->select(
                'colleges.college_name',
                DB::raw('count(students.student_id) as total_population'),
                DB::raw('count(CASE WHEN attendances.total_hours >= 3 THEN students.student_id END) as attendees')
            )
            ->join('students', 'students.student_id', '=', 'attendances.student_id')
            ->join('programs', 'programs.program_id', '=', 'students.program_id')
            ->join('colleges', 'colleges.college_id', '=', 'programs.college_id')
            ->groupBy('colleges.college_name')
            ->get();

        // Check if there are results
        if ($response->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => "No data set yet"
                ],
                404
            );
        }

        // Calculate the percentage and add it to the response
        $attendeesPercentage = $response->map(function ($item) {
            $item->percentage = $item->attendees / $item->total_population * 100;
            return $item;
        });

        // Return the results with the percentage
        return response()->json(
            [
                'status' => 'success',
                'message' => "Retrieved colleges and information",
                'data' => $attendeesPercentage
            ],
            200
        );
    }
}
