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

        $formattedData = ['data' => []];

        foreach ($colleges as $college) {
            $collegeName = $college->college_name;

            // Fetch programs for the current college
            $programs = DB::table('programs')
                ->select('program_id', 'program_name')
                ->where('college_id', $id) // Adjust this condition based on your requirement
                ->get();

            // Add college_name to the formatted data
            $formattedData['data'][] = ['college_name' => $collegeName];

            // Add programs under the respective college_name
            foreach ($programs as $program) {
                $formattedData['data'][] = [
                    'program_id' => $program->program_id,
                    'program_name' => $program->program_name,
                ];
            }
        }

        return response()->json($formattedData);
    }

}
