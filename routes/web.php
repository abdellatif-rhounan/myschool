<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\SubjectController;

Route::permanentRedirect('/', 'login')->name('home');

// ******** Auth Routes ********
Route::controller(AuthController::class)->group(function () {
	Route::get('login', 'login')->name('login');
	Route::post('login', 'authLogin');

	Route::get('logout', 'logout')->name('logout');

	Route::get('forgot-password', 'forgotPassword')->name('forgotPassword');
	Route::post('forgot-password', 'postForgotPassword');

	Route::get('reset-password/{token}', 'resetPassword')->name('resetPassword');
	Route::post('reset-password/{token}', 'postResetPassword');
});

// ******** Routes Need Authentication ********
Route::middleware('auth')->group(function () {
	// ******** Dashboard Route ********
	Route::view('dashboard', 'dashboard')->name('dashboard');

	// ******** Resources Routes ********
	Route::resource('admins', AdminController::class)->middleware('role_user:admin');

	Route::resource('classes', ClasseController::class);

	Route::resource('subjects', SubjectController::class);
});
