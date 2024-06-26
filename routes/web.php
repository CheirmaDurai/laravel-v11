<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiddlewareController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', [LoginController::class, 'getCSRFToken']);
Route::get('/authenticate', [LoginController::class, 'authenticate']);

Route::resource('home', HomeController::class)->middleware('auth');
Route::get('update-request', [MiddlewareController::class, 'preProcessor'])->middleware('process-request');
Route::get('update-response', [MiddlewareController::class, 'postProcessor'])->middleware('process-response');
Route::get('update-request-response', [MiddlewareController::class, 'middlewarePreAndPostProcessor'])->middleware('processor');
