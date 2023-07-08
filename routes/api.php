<?php

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


Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::post('/create-account', [App\Http\Controllers\AuthController::class, 'register']);
Route::get('/statistics',App\Http\Controllers\Api\DashboardController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //log out
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    /**
     *
     * Bin Routes
     */

    Route::resource('/bins', App\Http\Controllers\Api\ReportController::class);

    Route::get('/notifications',App\Http\Controllers\Api\NotificationController::class);

    Route::get('/supervisors', function () {
        return response(App\Models\User::where('role', 'Supervisor')->select('id', 'name', 'email', 'phone_number')->get());
    });

    Route::get('/reports/levels',[App\Http\Controllers\Api\ReportController::class,'exportBinLevels']);
    Route::get('/reports/quality',[App\Http\Controllers\Api\ReportController::class,'exportAirQuality']);
    Route::get('/s-reports/levels/{id}',[App\Http\Controllers\Api\ReportController::class,'singleBinLevel']);
    Route::get('/s-reports/levels/{id}',[App\Http\Controllers\Api\ReportController::class,'singleAirQuality']);

    Route::post('/delete-staff/{id}',[App\Http\Controllers\Api\UserManagementController::class, 'logout']);
});
