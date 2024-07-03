<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\DashboardController;

// ******** Auth Routes ********
Route::controller(AuthController::class)->group(function () {
  Route::get('login', 'login')->name('login');
  Route::post('login', 'authLogin');

  Route::get('logout', 'logout')->name('logout');

  Route::get('register', 'register')->name('register');
  Route::post('register', 'postRegister');

  Route::get('forgot-password', 'forgotPassword')->name('forgotPassword');
  Route::post('forgot-password', 'postForgotPassword');

  Route::get('reset-password/{token}', 'resetPassword')->name('resetPassword');
  Route::post('reset-password/{token}', 'postResetPassword');
});

// ******** Dashboard Routes ********
Route::get('dashboard', [DashboardController::class, 'dashboard'])
  ->name('dashboard')
  ->middleware('auth');

// ******** Admin Module Routes ********
Route::resource('admins', AdminController::class)->except('show');

// ******** Classes Module Routes ********
Route::resource('classes', ClasseController::class)->except('show');
