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
        if (Auth::check()) {
            switch (Auth::user()->role) {
                case 1:
                    return to_route('dashboard.admin');
                case 2:
                    return to_route('dashboard.teacher');
                case 3:
                    return to_route('dashboard.student');
                case 4:
                    return to_route('dashboard.guardian');
            }
        }

        return $next($request);
    }
}
