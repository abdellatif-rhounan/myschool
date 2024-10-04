<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function frame() {
        return view('frames.dashboard');
    }

    public function teacher() {
        return view('teachers.dashboard');
    }

    public function student() {
        return view('students.dashboard');
    }

    public function tutor() {
        return view('tutors.dashboard');
    }
}
