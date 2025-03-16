<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResponseModel;
use App\Models\RespondentModel;
use Illuminate\Support\Facades\Crypt;

class RecordsController extends Controller
{
    // index
    public function index() {
        try {
            
            // RESPONSES
            $responses = $this->get_response();

            // RESPONDENTS
            $respondents = $this->get_respondents();

            // return view with compact
            return view('auth.records', [
                'responses' => $responses
            ]);

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    
    private function get_response() {
        try {
            // get all responses
            $responses = ResponseModel::join('respondents', 'response.respondent_id', '=', 'respondents.id')
                                        ->select('response.*',
                                                 'respondents.first_name AS fname',
                                                 'respondents.middle_name AS mname',
                                                 'respondents.last_name AS lname',
                                                 )
                                        ->get();
            
                                        // RETURN RESPONSE
            return $responses;
        } catch (\Throwable $th) {
            return response(json(['error' => $th->getMessage()], 500));
        }
    }

    //get respondent names
    private function get_respondents() {
        try {
            return RespondentModel::select('id', 'first_name', 'middle_name', 'last_name')
                ->orderBy('first_name')
                ->get()
                ->map(function($respondent){
                    $respondent->encrypted_id = Crypt::encrypt($respondent->id);
                    return $respondent;
                });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
