<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class UserListController extends Controller
{
    public function view_users_list() {
        try {
            // get all users
            $users = User::AllUser();

            // return view users list page
            return view('auth.users-list', [
                'users' => $users
            ]);
        } catch (\Throwable $th) {
            Log::error("Error : ". $th->getMessage());
            abort(500);
        }
    }

    // add new user
    public function add_new_user(Request $request) {
        try {
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'confirmed', 'min:8']
            ]);

            // check if it fails then throw 409 status code for conflict
            if($validator->fails()){
                $errors = $validator->errors();

                Log::error("Validation errors: " . json_encode($errors->toArray(), JSON_PRETTY_PRINT));
                return response()->json([], 422);
            }

            // add user
            $add_status = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // if fail to save data in data base
            if(!$add_status){
                Log::error("Failed to create account!");
                return response()->json([], 500);
            }

            // return success response
            return response()->json([], 200);
        } catch (\Throwable $th) { // catch errors and exceptions
            Log::error("Error : ". $th->getMessage());
            return response()->json([], 500);
        }
    }

    // delete user
    public function delete_user($id) {
        try {
            /**
             * check if id query was present
             * if not then response 404 and log error in the logs
             */
            if(!$id){
                Log::error("User id not found in uri query");
                return response()->json([], 404);
            }

            $decrypted_id = Crypt::decrypt($id); //decrypt id

            $delete_status = User::delete_row($decrypted_id); // delete row

            // check delete status
            if(!$delete_status){
                Log::error("Failed to delete user");
                return response()->json([], 500);
            }

            return response()->json([], 200); // return response 200 status code
        } catch (\Throwable $th) {
            Log::error("Error : ".$th->getMessage());
            return response()->json([], 500);
        }
    }

    // get user data
    public function get_user_data($id) {
        try {
            $decrypted_id = Crypt::decrypt($id); // decrypt id

            $user_data = User::get_row($decrypted_id); // get user data

            /**
             * check if user was present
             * if not then throw response 404
             * log an error in laravel log
             */
            if(!$user_data){
                Log::error("Error : user cannot be found");
                return response()->json([], 404);
            }

            return response()->json(['data' => $user_data], 200); // return user data
        } catch (\Throwable $th) { // catch errors and excpeptions
            Log::error("Error : ".$th->getMessage());
            return response()->json([], 500);
        }
    }

    // edit user
    public function edit_user(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'edit_id' => 'required',
                'edit_name' => 'required',
                'edit_email' => ['required', 'email']
            ]);

            if($validator->fails()){
                $errors = $validator->errors();

                Log::error("Error : " . json_encode($errors->toArray(), JSON_PRETTY_PRINT));
                return response()->json([], 422, $headers);
            }

            if (!empty($request->edit_new_password) || !empty($request->edit_new_password_confirmation)) {
                if ($request->edit_new_password !== $request->edit_new_password_confirmation) {
                    Log::error("Error : password and confirm-password does not match");
                    return response()->json([], 422);
                }
            }

            $decrypted_id = Crypt::decrypt($request->edit_id);

            $user_prev_data = User::find($decrypted_id);

            if(!$user_prev_data){
                Log::error("Error : User not found for editing, check the request payload if the edit_id was present");
                return response()->json([], 404);
            }

            $email_unique_checker = User::where('email', $request->edit_email)
                ->whereNot('email', $user_prev_data->email)
                ->first();

            if($email_unique_checker){
                Log::error("Error : user update failed, email already exists!");
                return response()->json([], 409);
            }

            if(!empty($request->edit_new_password) && !empty($request->edit_new_password_confirmation)){
                $update_data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->edit_new_password)
                ];
            }else{
                $update_data = [
                    'name' => $request->name,
                    'email' => $request->email
                ];

            }

            $update_status = User::update_row($update_data, $decrypted_id);

            if(!$update_status){
                Log::error("Error : failed to update user");
                return response()->json([], 500);
            }

            return response()->json([], 200);

        } catch (\Throwable $th) {
            return response()->json([], 500);
        }
    }
}
