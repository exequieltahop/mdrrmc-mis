<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    // view login user
    public function view_login() {
        return view('guest.login');
    }

    // Log In user
    public function loginUser(Request $request) {
        try {
            // validate
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8']
            ]);


            // authenticate user acct
            if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return response()->json(['special_error' => 'Wrong Email or Password'], 401);
            }

            // return response json
            return response()->json(['success' => 1, 'url' => '/dashboard']);
        } catch (\Throwable $th) {
            // return error
            return response()->json(['error' => $th->getMessage()], 404);
        }
    }

    // LOGOUT USER
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
