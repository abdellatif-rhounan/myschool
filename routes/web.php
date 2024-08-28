<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClasseSubjectController;
use App\Http\Controllers\ClasseTeacherController;

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
	// Admin Related Routes
	Route::resource('admins', AdminController::class)->middleware('role_user:admin');

	// Teacher Related Routes
	Route::resource('teachers', TeacherController::class);

	// Student Related Routes
	Route::resource('students', StudentController::class);

	Route::get('my-subjects', [StudentController::class, 'mySubjects'])->name('my-subjects');

	// Parent Related Routes
	Route::resource('parents', ParentController::class);

	Route::controller(ParentController::class)->group(function () {
		Route::name('parents.')->group(function () {
			Route::get('parents/{parent}/students', 'showStudents')->name('students');
			Route::post('parents/{parent}/assign-student/{studentID}', 'assignStudent')->name('assignStudent');
			Route::delete('parents/remove-student/{student}', 'removeStudent')->name('removeStudent');
		});

		// Parent Side
		Route::get('my-children', 'myChildren')->name('my-children');
		Route::get('my-child/{student}/subjects', 'myChildSubjects')->name('my-child-subjects');
	});

	// Class Related Routes
	Route::resource('classes', ClasseController::class);

	Route::controller(ClasseController::class)->group(function () {
		Route::name('classes.')->group(function () {
			Route::get('classes/{class}/students', 'showStudents')->name('students');
			Route::post('classes/{class}/assign-student/{student}', 'assignStudent')->name('assignStudent');
			Route::delete('classes/remove-student/{student}', 'removeStudent')->name('removeStudent');
		});
	});

	// Subject Related Routes
	Route::resource('subjects', SubjectController::class);

	// Class Subject Related Routes
	Route::resource('classes-subjects', ClasseSubjectController::class);

	// Class Teacher Related Routes
	Route::resource('classes-teachers', ClasseTeacherController::class);

	// User Related Routes
	Route::controller(UserController::class)->group(function () {
		Route::get('profile', 'profile')->name('profile');
		Route::get('profile/edit', 'editProfile')->name('profile-edit');
		Route::put('profile/edit', 'updateProfile');

		Route::get('change-password', 'changePassword')->name('change-password');
		Route::post('change-password', 'postChangePassword');
	});
});
