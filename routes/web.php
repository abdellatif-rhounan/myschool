<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::permanentRedirect('/', 'login')->name('root');

// ******** Auth Routes ********
Route::controller(AuthController::class)->group(function () {

    Route::middleware('guestUser')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate');

        Route::get('forgot-password', 'forgotPassword')->name('password.request');
        Route::post('forgot-password', 'postForgotPassword')->name('password.email');

        Route::get('reset-password/{token}', 'resetPassword')->name('password.reset');
        Route::post('reset-password/{token}', 'postResetPassword')->name('password.update');
    });

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

// Dashboard Routes
Route::middleware('auth')->name('dashboard.')->group(function () {
    Route::view('admin/dashboard', 'admin.dashboard')->middleware('userRole:1')->name('admin');
    Route::view('teacher/dashboard', 'teacher.dashboard')->middleware('userRole:2')->name('teacher');
    Route::view('student/dashboard', 'student.dashboard')->middleware('userRole:3')->name('student');
    Route::view('guardian/dashboard', 'guardian.dashboard')->middleware('userRole:4')->name('guardian');
});
