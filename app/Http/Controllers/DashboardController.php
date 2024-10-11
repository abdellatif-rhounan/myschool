<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $guards = ['frame', 'teacher', 'student', 'tutor'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) return view($guard . 's.dashboard');
        }

        return to_route('login');
    }
}
