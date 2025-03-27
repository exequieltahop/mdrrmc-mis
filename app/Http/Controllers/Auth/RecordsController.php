<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResponseModel;
use App\Models\RespondentModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Carbon;

class RecordsController extends Controller
{
    // VIEW RECORD BLADE
    public function index() {
        try {

            // RESPONSES
            $responses = $this->get_response();
            // dd($responses);
            // RESPONDENTS
            $respondents = $this->get_respondents();

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
            $response = ResponseModel::find($decrypted_id);

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

    // get record
    public function get_record($id) {
        try {
            // decrypt encrypted id
            $decrypted_id = Crypt::decrypt($id);

            // get response data for edit
            $data_raw = ResponseModel::getRecord(['*'], $decrypted_id)
                ->get()
                ->map(function($query){ // map data for respondents fullname
                    /**
                     * $respondent_array for storing the full names of the responders
                     * $respondent_id for the extracted data from string into array
                     * $respondent_id_count for array length of the respondent array ids
                     */
                    $respondent_array = [];
                    $respondent_id = explode(",", $query->respondent_id);
                    $respondent_id_count = count($respondent_id);

                    /**
                     * for looping the array then get full name of the responders
                     * from the database as save it into the array $respondent_array
                     */
                    foreach($respondent_id as $id){
                        $name_data = RespondentModel::fullName($id)->first();
                        $respondent_array[] = $name_data->full_name;
                    }

                    /**
                     * check if count of the $respondent_array is equal to
                     * the actual array length of the respondent
                     */
                    if(count($respondent_array) == $respondent_id_count){
                        $query->respondent_full_names = $respondent_array;
                    }

                    // format datetime
                    $query->formatted_date_time = $query->date_time->format('Y-m-d\TH:i');

                    return $query; // return query
                });
            // dd($data_raw);

            return response()->json(['data' => $data_raw], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // update record
    public function update_record(Request $request) {
        try {
            // validate request
            $request->validate([
                'id' => ['required'],
                'respondent' => ['required', 'array'],
                'respondent.*' => ['string'],
                'location' => ['required'],
                'datetime' => ['required'],
                'involve' => ['required'],
                'hospital' => ['required'],
                'cause' => ['required'],
                'incident_type' => ['required']
            ]);

            // decrypt id
            $record_id = Crypt::decrypt($request->id);

            // prepare array to store ids of the responders
            $respondent_ids_array_decrypted = [];

            /**
             * loop all responders id and decrypt it
             * then save it into $respondent_ids_array_decrypted array
            */
             foreach($request->respondent as $respo){
                $respondent_ids_array_decrypted[] = Crypt::decrypt($respo);
            }

            $respondent_ids = implode(", ", $respondent_ids_array_decrypted); // make and array from string

            // make update data
            $update_data = [
                'respondent_id' => $respondent_ids,
                'location' => $request->location,
                'date_time' => $request->datetime,
                'involve' => $request->involve,
                'refered_hospital' => $request->hospital,
                'incident_type' => $request->incident_type,
                'immediate_cause_or_reason' => $request->cause,
                'remark' => $request->remarks
            ];

            // updat row
            $update_status = ResponseModel::UpdateRow($update_data, $record_id);

            // check if update successfully if not then throw new Exception
            if(!$update_status){
                throw new \Exception("Failed to update");
            }

            // return response success
            return response()->json(['success' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
