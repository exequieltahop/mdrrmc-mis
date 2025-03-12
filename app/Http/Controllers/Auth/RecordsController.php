<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResponseModel;

class RecordsController extends Controller
{
    // index
    public function index() {
        try {
            // get all responses
            $responses = ResponseModel::join('respondents', 'response.respondent_id', '=', 'respondents.id')
                                        ->select('response.*',
                                                 'respondents.first_name AS fname',
                                                 'respondents.middle_name AS mname',
                                                 'respondents.last_name AS lname',
                                                 )
                                        ->get();
            // $responses = ResponseModel::with('respondent_relation')->get();

            // dd($responses);

            // return view with compact
            return view('auth.records', compact('responses'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
