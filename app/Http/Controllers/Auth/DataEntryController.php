<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResponseModel;
use App\Models\RespondentModel;
use Illuminate\Support\Facades\Crypt;

class DataEntryController extends Controller
{
    public function index() {
        try {
            // RESPONDENTS
            $respondents = $this->get_respondents();
            
            
            // RETURN VIEW WITH DATA
            return view('auth.data-entry', 
                [
                    'respondents' => $respondents, 
                ]
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Save Submitted Response
    public function submit_response(Request $request) {
        try {

            // validate request
            $request->validate([
                'respondent' => ['required', 'array'],
                'respondent.*' => ['string'],
                'location' => ['required'],
                'datetime' => ['required'],
                'involve' => ['required'],
                'hospital' => ['required'],
                'cause' => ['required'],
                'incident_type' => ['required']
            ]);

            // make new empty array for the data to save(the decrypted ids of the respondent)
            $respondent_ids = [];

            // loop the encrypted ids
            foreach($request->respondent as $respondent){
                $respondent_ids[] = Crypt::decrypt($respondent);
            }

            // save data
            ResponseModel::create([
                'respondent_id' => implode(', ', $respondent_ids),
                'location' => $request->location,
                'date_time' => $request->datetime,
                'involve' => $request->involve,
                'refered_hospital' => $request->hospital,
                'incident_type' => $request->incident_type,
                'immediate_cause_or_reason' => $request->cause,
                'remark' => $request->remarks,
            ]);

            // return response
            return response()->json(['success' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
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
