<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthChecker;
use App\Http\Controllers\Guest\IndexController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\DataEntryController;
use App\Http\Controllers\Auth\RecordsController;
use App\Http\Controllers\Auth\RespondentController;
use App\Http\Middleware\RoleChecker;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\UserListController;

// GUEST
Route::get('/', [IndexController::class, 'view_login'])->name('log_in');
    Route::post('/login-user', [IndexController::class, 'loginUser']);
    Route::get('/logout', [IndexController::class, 'logout'])->name('logout');

// AUTHENTICATED ROUTE
// Route::group(['prefix' => '', 'middleware' => ['authChecker']], function(){

// });

Route::group(['prefix' => '', 'middleware' => ['authChecker']], function(){

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // DATA ENTRY
    Route::get('/data-entry', [DataEntryController::class, 'index'])->name('data-entry');
        Route::post('/submit-response', [DataEntryController::class, 'submit_response']);

    // RECORDS
    Route::get('/records', [RecordsController::class, 'index'])->name('records');
        Route::delete('/delete/{id}', [RecordsController::class, 'delete_record']);
        Route::get('/get-record/{id}', [RecordsController::class, 'get_record']);
        Route::put('/update-record', [RecordsController::class, 'update_record']);

    // RESPONDENTS
    Route::get('/respondents', [RespondentController::class, 'index'])
        ->name('respondents')
        ->middleware(RoleChecker::class.':admin');

        Route::post('/add-respondent', [RespondentController::class,'add_respondent'])->middleware(RoleChecker::class.':admin');

        Route::delete('/delete-responder/{id}', [RespondentController::class,'delete_responder']);
        Route::get('/get-responder-data/{id}', [RespondentController::class,'get_responder_data']);
        Route::post('/edit-respondent', [RespondentController::class,'update_responder']);

        Route::get('/responder/photo/{filename}', [RespondentController::class, 'get_responder_photo'])
            ->name('get.responder.photo');

    // users list
    Route::get('/users-list', [UserListController::class, 'view_users_list'])->name('users.list');
        Route::post('/add-new-user', [UserListController::class, 'add_new_user']);
        Route::delete('/delete-user/{id}', [UserListController::class, 'delete_user']);
        Route::get('/get-user-data/{id}', [UserListController::class, 'get_user_data']);
        Route::put('/edit-user', [UserListController::class, 'edit_user']);
});
