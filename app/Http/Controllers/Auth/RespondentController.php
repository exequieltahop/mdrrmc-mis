<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RespondentModel;
use Carbon\Carbon;

class RespondentController extends Controller
{
    // INDEX FUNCTION VIEW BLADE RESPONDENTS
    public function index() {
        try {
            // GET RESPONDENTS
            $respondents = RespondentModel::select('*')
                ->orderBy('first_name')
                ->get()
                ->map(function($respo){
                    $respo->age = Carbon::parse($respo->birthdate)->age;
                    return $respo;
                });

            // RETURN VIEW RESPONDENTS
            return view('auth.respondents', compact('respondents'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
                $path = $request->file('photo')->store('user-profile', 'public');
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
}
