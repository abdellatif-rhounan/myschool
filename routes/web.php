<?php

use Illuminate\Support\Facades\Route;

use App\Enums\Role;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

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
    Route::view('admin/dashboard', 'admin.dashboard')->middleware('userRole:' . Role::ADMIN->value)->name('admin');
    Route::view('teacher/dashboard', 'teacher.dashboard')->middleware('userRole:' . Role::TEACHER->value)->name('teacher');
    Route::view('student/dashboard', 'student.dashboard')->middleware('userRole:' . Role::STUDENT->value)->name('student');
    Route::view('guardian/dashboard', 'guardian.dashboard')->middleware('userRole:' . Role::GUARDIAN->value)->name('guardian');
});

// ******** Resources Routes ********
Route::middleware(['auth', 'userRole:' . Role::ADMIN->value])->group(function () {
    Route::resource('admins', AdminController::class)->parameters([
        'admins' => 'user',
    ]);

    Route::resource('teachers', TeacherController::class)->parameters([
        'teachers' => 'user',
    ]);

    Route::resource('students', StudentController::class)->parameters([
        'students' => 'user',
    ]);

    Route::resource('guardians', GuardianController::class)->parameters([
        'guardians' => 'user',
    ]);
});
