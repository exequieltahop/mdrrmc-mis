<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RespondentModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RespondentController extends Controller
{
    // INDEX FUNCTION VIEW BLADE RESPONDENTS
    public function index() {
        try {
            // GET RESPONDENTS
            $respondents = RespondentModel::select('*')
                ->orderBy('first_name')
                ->get()
                ->map(function ($respo) {
                    $respo->encrypted_id = Crypt::encrypt($respo->id);
                    $respo->age = Carbon::parse($respo->birthdate)->age;

                    // Get the file contents
                    if (Storage::disk('local')->exists($respo->photo)) {
                        $respo->photo_file = route('get.responder.photo', ['filename' => basename($respo->photo)]);
                    }

                    return $respo;
                });

            // RETURN VIEW RESPONDENTS
            return view('auth.respondents', compact('respondents'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // ADD RESPONDENT
    public function add_respondent(Request $request) {
        try {
            // validate request
            $request->validate([
                'fname' => ['required'],
                'mname' => ['required'],
                'lname' => ['required'],
                'gender' => ['required'],
                'address' => ['required'],
                'birthdate' => ['required', 'date', 'before:today'],
                'birthplace' => ['required'],
                'civil_status' => ['required'],
                'photo' => ['required', 'mimes:png,jpg,jpeg', 'max:10250'],
            ]);

            // upload file
            if($request->hasFile('photo')){
                $path = Storage::disk('local')->put('responder-profile', $request->file('photo'));
            }

            // check if file upload was ok
            if($path){
                // add new respondent
                $new_respondent = RespondentModel::create([
                    'first_name' => $request->fname,
                    'middle_name' => $request->mname,
                    'last_name' => $request->lname,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'birthdate' => $request->birthdate,
                    'birthplace' => $request->birthplace,
                    'civil_status' => $request->civil_status,
                    'photo' => $path,
                ]);
            }

            // check if respondent was successfully added
            if(!$new_respondent){
                return response()->json(['error' => 'Failed To Add Respondent, Please Try Again, If The Problem Persist Contact Developer'], 400);
            }

            // return response
            return response()->json(['success' => 1, 'new _user' => $new_respondent]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // delete responder
    public function delete_responder($id) {
        try {
            $decrypted_id = Crypt::decrypt($id);

            $delete_status = RespondentModel::deleteRow($decrypted_id);

            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // get responder data
    public function get_responder_data($id) {
        try {
            // decrypt id
            $decrypted_id = Crypt::decrypt($id);

            // Get responder data
            $responder_data = RespondentModel::find($decrypted_id);


            // if responder data is 0 then return response 404
            if(!$responder_data){
                Log::info("Responder Not Found : responder id = $decrypted_id");
                return response()->json([], 404);
            }

            if ($responder_data) {
                // Encrypt ID and assign it as a new attribute
                $responder_data->encrypted_id = Crypt::encrypt($responder_data->id);
            }

            // return response with the data
            return response()->json(['data' => $responder_data], 200);
        } catch (\Throwable $th) {
            // log error
            Log::info("Error : ".$th->getMessage());
            // return response error status code 500 server server
            return response()->json([], 500);
        }
    }

    // update responder
    public function update_responder(Request $request) {
        try {
            // validate request
            $request->validate([
                'edit_id' => ['required'],
                'edit_fname' => ['required'],
                'edit_mname' => ['required'],
                'edit_lname' => ['required'],
                'edit_gender' => ['required'],
                'edit_address' => ['required'],
                'edit_birthdate' => ['required', 'date', 'before:today'],
                'edit_birthplace' => ['required'],
                'edit_civil_status' => ['required'],
                'edit_photo' => ['mimes:png,jpg,jpeg', 'max:10250'],
            ]);

            $decrypted_id = Crypt::decrypt($request->edit_id);// decrypt id

            $item = RespondentModel::find($decrypted_id);

            // if has file then save file in the private storage
            if($request->hasFile('edit_photo')){
                $path = Storage::disk('local')->put('responder-profile', $request->file('edit_photo'));
            }else{
                $path = $item->photo;
            }


            // if path was present then update row in database
            if($path){

                // data for update, keys as column and values as values
                $data = [
                    'first_name' => $request->edit_fname,
                    'middle_name' => $request->edit_mname,
                    'last_name' => $request->edit_lname,
                    'gender' => $request->edit_gender,
                    'address' => $request->edit_address,
                    'birthdate' => $request->edit_birthdate,
                    'birthplace' => $request->edit_birthplace,
                    'civil_status' => $request->edit_civil_status,
                    'photo' => $path
                ];

                // update row
                $update_status = RespondentModel::updateRow($data, $decrypted_id);

                /**
                 * check update status if false
                 * then log error in the laravel log
                 * then return status 400 bad request
                 */
                if(!$update_status){
                    Log::error("Error : Failed to update responder");
                    return response()->json([], 400);
                }

                return response()->json([], 200); // return a 200 status
            }
        } catch (\Throwable $th) {
            Log::error("Error: ".$th->getMessage()); // log errors
            return response()->json([], 500); // return status 500 internal server error
        }
    }

    public function get_responder_photo($filename) {

        if (!Storage::disk('local')->exists('responder-profile/'.$filename)) {
            return response()->file(public_path('assets/icons/user.png'));
        }else{
            return response()->file(storage_path('app/private/responder-profile/' . $filename));
        }
    }
}
