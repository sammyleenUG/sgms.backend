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


//login in
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);


// create new account
Route::post('/create-account', [App\Http\Controllers\AuthController::class, 'register']);


/*
    get hostels
    url can be written as /hostels?results=50&with_room_types=0
    by default, results = 10 and with_room_types = 1
*/

Route::get('/hostels', [App\Http\Controllers\HostelsController::class, 'index']);

//get hostel details
Route::get('/hostels/{hostel_id}',App\Http\Controllers\SingleHostelController::class);


/*
    get user distance from hostel
    url can be written as /distance?id=50&latitude=0.3456&longitude=32.34567
*/
Route::get('/distance',App\Http\Controllers\DistanceController::class);

//near-by hostels
Route::get('/near-me',App\Http\Controllers\NearMeController::class);


Route::group(['middleware' => ['auth:sanctum']], function () {

    //log out
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    //new hostel
    Route::post('/add-hostel', [App\Http\Controllers\HostelsController::class, 'store']);

    //update hostel
    Route::post('/update-hostel/{id}', [App\Http\Controllers\HostelsController::class, 'update']);

    //delete hostel
    Route::delete('/delete-hostel/{id}', [App\Http\Controllers\HostelsController::class, 'destroy']);

    //new room type
    Route::post('/add-room-type', App\Http\Controllers\RoomTypeController::class);

});
