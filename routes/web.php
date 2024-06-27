<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ****** Auth Routes ******
Route::get('login', [AuthController::class, 'login']);

Route::post('login', [AuthController::class, 'authLogin']);

Route::get('logout', [AuthController::class, 'logout']);

Route::get('register', [AuthController::class, 'register']);

Route::post('register', [AuthController::class, 'postRegister']);

Route::get('forgot-password', [AuthController::class, 'forgotPassword']);

Route::post('forgot-password', [AuthController::class, 'postForgotPassword']);

Route::get('reset-password/{token}', [AuthController::class, 'resetPassword']);

Route::post('reset-password/{token}', [AuthController::class, 'postResetPassword']);

// Dashboard
Route::get('dashboard', [DashboardController::class, 'dashboard']);
