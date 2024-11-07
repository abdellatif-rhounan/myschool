<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::permanentRedirect('/', 'login')->name('root');

// ******** Auth Routes ********
Route::controller(AuthController::class)->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate');

        Route::get('forgot-password', 'forgotPassword')->name('password.request');
        Route::post('forgot-password', 'postForgotPassword')->name('password.email');

        Route::get('reset-password/{token}', 'resetPassword')->name('password.reset');
        Route::post('reset-password/{token}', 'postResetPassword')->name('password.update');
    });

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

// Dashboard Route
Route::get('dashboard', function () {
    return "dashboard view";
})->name('dashboard');
