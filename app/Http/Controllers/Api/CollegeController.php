<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class CollegeController extends Controller
{
    public function getProgramsByCollege(string $id)
    {
        $response = DB::table('colleges')
            ->select(
                'colleges.college_name',
                'programs.program_id',
                'programs.program_name',
            )
            ->join('programs', 'programs.college_id', '=', 'colleges.college_id')
            ->get();

        return response()->json(
            [
                'data' => $response
            ],
        );
    }
}
