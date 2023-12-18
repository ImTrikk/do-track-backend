<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class CollegeController extends Controller
{
    public function getProgramsByCollege(string $id)
    {
        $colleges = DB::table('colleges')
            ->select('college_name')
            ->where('college_id', '=', $id)
            ->get();



        // Fetch programs for the current college
        $programs = DB::table('programs')
            ->select('program_id', 'program_name')
            ->where('college_id', $id)
            ->get();


        return response()->json(
            [
                'data' => [
                    'college' => $colleges,
                    'programs' => $programs
                ],
            ],
        );
    }

}
