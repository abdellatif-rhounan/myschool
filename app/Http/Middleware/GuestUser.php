<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $guards = ['frame', 'teacher', 'student', 'tutor'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) return to_route('dashboard');
        }

        return $next($request);
    }
}
