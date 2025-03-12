<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RespondentModel;
use App\Models\User;
use App\Models\ResponseModel;

class DashboardController extends Controller
{
    public function index() {
        $total_respondent = RespondentModel::count();
        $total_user = User::select('id')->where('role', '!=', 'admin')->count();
        $total_response = ResponseModel::count();

        return view('auth.dashboard', compact('total_respondent', 'total_user', 'total_response'));
    }
}
