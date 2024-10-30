<?php

use App\Http\Controllers\AUTH\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(JwtMiddleware::class)->group(function ()
{
    Route::get('users', [UserController::class, 'index']);
});