<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseStudentController;
use App\Http\Controllers\ClasseSubjectController;
use App\Http\Controllers\ClasseTeacherController;

Route::permanentRedirect('/', 'login')->name('root');

// ******** Auth Routes ********
Route::controller(AuthController::class)->group(function () {

	Route::middleware('guest_user')->group(function () {
		Route::get('login', 'login')->name('login');
		Route::post('login', 'authenticate');

		Route::get('forgot-password', 'forgotPassword')->name('forgot-password');
		Route::post('forgot-password', 'postForgotPassword');

		Route::get('{user_type}/reset-password/{remember_token}', 'resetPassword')->name('reset-password');
		Route::patch('{user_type}/reset-password/{remember_token}', 'postResetPassword');
	});

	Route::get('logout', 'logout')->name('logout')->middleware('auth_user');
});

// ******** Dashboard Routes ********
Route::controller(DashboardController::class)->name('dashboard.')->group(function () {
	Route::get('frame/dashboard', 'frame')->name('frame')->middleware('auth:frame');
	Route::get('teacher/dashboard', 'teacher')->name('teacher')->middleware('auth:teacher');
	Route::get('student/dashboard', 'student')->name('student')->middleware('auth:student');
	Route::get('tutor/dashboard', 'tutor')->name('tutor')->middleware('auth:tutor');
});

// ******** Routes Need Authentication ********
Route::middleware('auth')->group(function () {
	// ******** Resources Routes ********
	// Admin Related Routes
	Route::resource('admins', AdminController::class)->middleware('role_user:admin');

	// Teacher Related Routes
	Route::resource('teachers', TeacherController::class);

	Route::get('my-classes-subjects', [TeacherController::class, 'myClassesSubjects'])->name('my-classes-subjects');
	Route::get('my-classes-students', [TeacherController::class, 'myClassesStudents'])->name('my-classes-students');

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

	// Class Student Related Routes
	Route::resource('classes-students', ClasseStudentController::class);

	// User Related Routes
	Route::controller(UserController::class)->group(function () {
		Route::get('profile', 'profile')->name('profile');
		Route::get('profile/edit', 'editProfile')->name('profile-edit');
		Route::put('profile/edit', 'updateProfile');

		Route::get('change-password', 'changePassword')->name('change-password');
		Route::post('change-password', 'postChangePassword');
	});
});
