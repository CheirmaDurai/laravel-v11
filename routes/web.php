<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/authenticate', [LoginController::class, 'authenticate']);

Route::resource('home', HomeController::class)->middleware('auth');;
