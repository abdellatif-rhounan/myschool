<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRole
{
    public function handle(Request $request, Closure $next, int $role): Response
    {
        if (Auth::user()->role !== $role) abort(401);

        return $next($request);
    }
}
