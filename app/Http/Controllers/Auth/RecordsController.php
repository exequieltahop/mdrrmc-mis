<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResponseModel;
use App\Models\RespondentModel;
use Illuminate\Support\Facades\Crypt;

class RecordsController extends Controller
{
    // VIEW RECORD BLADE
    public function index() {
        try {

            // RESPONSES
            $responses = $this->get_response();
            // RESPONDENTS
            $respondents = $this->get_respondents();
            // $res = RespondentModel::fullName(1)->first();
            // return view with compact
            return view('auth.records', [
                'responses' => $responses,
                'respondents' => $respondents
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // GET RESPONSES
    private function get_response() {
        try {
            // GET RESPONSES
            $responses = ResponseModel::select('*')
                ->get()
                ->map(function($query){ // MAP DATA FOR GETTING THE FULLNAME OF THE RESPONDERS
                    $query->encrypted_id = Crypt::encrypt($query->id);
                    if(strlen($query->respondent_id) > 1){

                        // MAKE THE RESPONDER ID INTO ARRAY
                        $array_ids = explode(",", $query->respondent_id);

                        // MAKE A BASE STRING FOR THE RESPONDERS NAME TO CONCAT
                        $query->respondents_name = "";

                        // GET ARRAY COUNT OF THE RESPONDERS
                        $count = count($array_ids);

                        // ITERATION BASE COUNT
                        $iteration_count = 1;

                        $loop_iteration = 0;

                        foreach($array_ids as $id){

                            // IF THE RESPONDERS COUNT EQUALS TO NUMBER OF LOOP ITERATION THEN REMOVE THE ", " STRING
                            if($count == $iteration_count){
                                $responder = RespondentModel::fullName($id)->first();
                                // dd($responder);
                                $query->respondents_name .= $responder->full_name;

                            }else{ // ELSE PUT STRING ", "
                                // dd($responder);
                                $responder = RespondentModel::fullName($id)->first();
                                // dd($responder[0]);
                                $query->respondents_name .=$responder->full_name . ", ";
                            }

                            // ADD 1 INTO EACH LOOP
                            $iteration_count++;
                            $loop_iteration++;
                        };

                    }else{ // JUST GET THE NAME OF THE RESPONDER
                        $responder = RespondentModel::fullName($query->respondent_id)->first();
                        // dd($responder);
                        $query->respondents_name .= $responder->full_name;

                    }

                    // RETURN QUERY
                    return $query;
                });

            // RETURN RESPONSE
            return $responses;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //GET RESPONDERS
    private function get_respondents() {
        try {
            return RespondentModel::select('id', 'first_name', 'middle_name', 'last_name')
                ->orderBy('first_name')
                ->get()
                ->map(function($respondent){ // ENCRYPT EACH ID
                    $respondent->encrypted_id = Crypt::encrypt($respondent->id);
                    return $respondent;
                });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // DELETE RECORD
    public function delete_record($id) {
        try {
            // DECRYPT ID
            $decrypted_id = Crypt::decrypt($id);

            // GET ROW
            $response = ResponseModel::find($id);

            // SOFT DELETE DATA
            $delete_status = $response->delete();

            // IF FAILED RETURN A ERROR
            if(!$delete_status){
                return response()->json(['special_error'=> 'Failed to delete response!'], 405);
            }

            // ELSE RETURN SUCCESS MESSAGE
            return response()->json(['success'=> 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
