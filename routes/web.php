<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| db user eyeproxxy_sam pwd O$GZ^5eUbS5t
*/

Route::get('/login-through-app',function(){
    return view('login');
});

Route::get('/forgot-password',function(){
    return view('forgotpassword');
});
