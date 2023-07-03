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

    Route::resource('/bins', App\Http\Controllers\Api\BinController::class);


    Route::get('/supervisors', function () {
        return response(App\Models\User::where('role', 'Supervisor')->select('id', 'name', 'email', 'phone_number')->get());
    });

    Route::post('/delete-staff/{id}',[App\Http\Controllers\Api\UserManagementController::class, 'logout']);
});
