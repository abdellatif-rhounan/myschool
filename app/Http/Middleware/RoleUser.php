<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleUser
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roles = [
            1 => 'admin',
            2 => 'teacher',
            3 => 'student',
            4 => 'parent',
        ];

        if ($role == $roles[Auth::user()->user_type]) {
            return $next($request);
        } else {
            Auth::logout();

            return to_route('login');
        }
    }
}
