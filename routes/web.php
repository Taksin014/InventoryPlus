<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LockScreen;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\ExpenseReportsController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainersController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\DispenserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    Route::get('home',function()
    {
        return view('home');
    });
});

Auth::routes();

// ----------------------------- main dashboard ------------------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    // Route::get('em/dashboard', 'emDashboard')->name('em/dashboard');
});

// -----------------------------settings----------------------------------------//
Route::controller(SettingController::class)->group(function () {
    Route::get('company/settings/page', 'companySettings')->middleware('auth')->name('company/settings/page');
    Route::get('roles/permissions/page', 'rolesPermissions')->middleware('auth')->name('roles/permissions/page');
    Route::post('roles/permissions/save', 'addRecord')->middleware('auth')->name('roles/permissions/save');
    Route::post('roles/permissions/update', 'editRolesPermissions')->middleware('auth')->name('roles/permissions/update');
    Route::post('roles/permissions/delete', 'deleteRolesPermissions')->middleware('auth')->name('roles/permissions/delete');
});

// -----------------------------login----------------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});


// ------------------------------ register ---------------------------------//
// Route::controller(RegisterController::class)->group(function () {
//     Route::get('/register', 'register')->name('register.form');
//     Route::post('/register','storeUser')->name('register');    
// });

// ----------------------------- forget password ----------------------------//
// Route::controller(ForgotPasswordController::class)->group(function () {
//     Route::get('forget-password', 'getEmail')->name('forget-password');
//     Route::post('forget-password', 'postEmail')->name('forget-password');    
// });

// ----------------------------- reset password -----------------------------//
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'getPassword');
    Route::post('reset-password', 'updatePassword');    
});

// ----------------------------- user profile ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('profile_user', 'profile')->middleware('auth')->name('profile_user');
    Route::post('profile/information/save', 'profileInformation')->name('profile/information/save');    
});

// ----------------------------- user userManagement -----------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('userManagement', 'index')->middleware('auth')->name('userManagement');
    Route::post('user/add/save', 'addNewUserSave')->name('user/add/save');
    Route::post('search/user/list', 'searchUser')->name('search/user/list');
    Route::post('update', 'update')->name('update');
    Route::post('user/delete', 'delete')->middleware('auth')->name('user/delete');
    Route::get('activity/log', 'activityLog')->middleware('auth')->name('activity/log');
    Route::get('activity/login/logout', 'activityLogInLogOut')->middleware('auth')->name('activity/login/logout');    
});

// ----------------------------- search user management ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::post('search/user/list', 'searchUser')->name('search/user/list');
});

// ----------------------------- form change password ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('change/password', 'changePasswordView')->middleware('auth')->name('change/password');
    Route::post('change/password/db', 'changePasswordDB')->name('change/password/db');    
});


    // ----------------------------- bill  ------------------------------//
Route::controller(BillController::class)->group(function () {

    // -------------------- bill  -------------------//
    Route::get('form/bill/page', 'billsIndex')->middleware('auth')->name('form/bill/page');
    Route::get('form/bill_history/page', 'bills_historyIndex')->middleware('auth')->name('form/bill_history/page');
    Route::get('create/bill/page', 'createEstimateIndex')->middleware('auth')->name('create/bill/page');
    // Route::get('edit/bill/{bill_number}', 'editEstimateIndex')->middleware('auth');
    // Route::get('bill/view/{bill_number}', 'viewEstimateIndex')->middleware('auth');
    Route::post('create/bill/save', 'createEstimateSaveRecord')->middleware('auth')->name('create/bill/save');
    Route::post('create/bill/update', 'EstimateUpdateRecord')->middleware('auth')->name('create/bill/update');
            // ---------------------- search expenses  ---------------//
    Route::get('bill/search', 'searchRecord')->middleware('auth')->name('bill/search');
    Route::post('bill/search', 'searchRecord')->middleware('auth')->name('bill/search');
    
});

// ----------------------------- approver  ------------------------------//
Route::controller(ApproverController::class)->group(function () {

    // -------------------- approver  -------------------//
    Route::get('form/approver/page', 'ApproverIndex')->middleware('auth')->name('form/approver/page');
    Route::get('form/permission_history/page', 'HistoryIndex')->middleware('auth')->name('form/permission_history/page');
    Route::post('form/approver/update', 'updateApprover')->middleware('auth')->name('form/approver/update');
    Route::get('/approver/view/{bill_number}', 'ApproverView')->middleware('auth');
            // ---------------------- search expenses  ---------------//
    Route::get('approver/search', 'searchApprover')->middleware('auth')->name('approver/search');
    Route::post('approver/search', 'searchApprover')->middleware('auth')->name('approver/search');
    
});


// ----------------------------- Verify  ------------------------------//
Route::controller(VerifyController::class)->group(function () {

    // -------------------- Verify  -------------------//
    Route::get('form/verify/page', 'VerifyIndex')->middleware('auth')->name('form/verify/page');
    Route::get('form/verify_history/page', 'Verify_historyIndex')->middleware('auth')->name('form/verify_history/page');
    Route::post('form/verify/update', 'updateVerified')->middleware('auth')->name('form/verify/update');
    Route::get('/verify/view/{bill_line_id}', 'VerifiedView')->middleware('auth');
    Route::get('/get-segment-desc', 'getSegmentDesc')->middleware('auth');
    Route::get('/get-reason-name', 'getReason')->middleware('auth');
    Route::get('/check-matching-row', 'checkMatchingRow')->middleware('auth');
            // ---------------------- search expenses  ---------------//
    Route::get('verify/search', 'searchRecord')->middleware('auth')->name('verify/search');
    Route::post('verify/search', 'searchRecord')->middleware('auth')->name('verify/search');
    
});


// ----------------------------- Dispenser  ------------------------------//
Route::controller(DispenserController::class)->group(function () {

    // -------------------- Dispenser  -------------------//
    Route::get('form/dispense/page', 'DispenseIndex')->middleware('auth')->name('form/dispense/page');
    Route::get('form/dispense_history/page', 'Dispense_historyIndex')->middleware('auth')->name('form/dispense_history/page');
    Route::get('/dispense/view/{bill_line_id}', 'DispenseView')->middleware('auth');
    Route::post('form/dispense/update', 'updateDispense')->middleware('auth')->name('form/dispense/update');
            // ---------------------- search expenses  ---------------//
    Route::get('dispense/search', 'searchRecord')->middleware('auth')->name('dispense/search');
    Route::post('dispense/search', 'searchRecord')->middleware('auth')->name('dispense/search');
    
});

