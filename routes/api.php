<?php

use App\Http\Controllers\LicenseController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LeaveApplicationController;
use App\Http\Controllers\API\LeaveTypeController;
use App\Http\Controllers\API\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('leave-types', [LeaveTypeController::class, 'index']);

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);

Route::get('/leave-applications', [LeaveApplicationController::class, 'index']);
Route::post('/leave-applications', [LeaveApplicationController::class, 'create']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

Route::post('test',[LicenseController::class,'store']);
Route::post('store',[PayrollController::class,'store']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
