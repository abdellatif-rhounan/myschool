<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Middleware\notAuth;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(notAuth::class, only: ['register', 'forgotPassword', 'resetPassword']),
        ];
    }

    public function login()
    {
        if (Auth::check()) {
            return to_route('dashboard');
        }

        return view('auth.login');
    }

    public function authLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        $remember = $request->remember ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return to_route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Wrong Credentials');
        }
    }

    public function logout()
    {
        Auth::logout();

        return to_route('login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users',
            'user_type' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required',
        ]);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->status = 1;

        switch ($request->user_type) {
            case 1:
                $user->user_type = 1;
                break;
            case 2:
                $user->user_type = 2;
                break;
            case 3:
                $user->user_type = 3;
                break;
            case 4:
                $user->user_type = 4;
                break;
            default:
                $user->user_type = 3;
                break;
        }

        $user->save();

        return to_route('login')->with('success', 'Account Created Successfuly');
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::select('id', 'name', 'remember_token')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email Not Found!');
        }

        $user->remember_token = Str::random(30);
        $user->save();

        Mail::to($request->email)->send(new ForgotPasswordMail($user));

        return to_route('login')->with('success', 'Email sent Successfully');
    }

    public function resetPassword(string $token)
    {
        $user = User::select('remember_token')
            ->where('remember_token', $token)
            ->first();

        if (!$user) {
            abort(404);
        }

        return view('auth.reset_password', ['token' => $user->remember_token]);
    }

    public function postResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $user = User::select('id', 'password', 'remember_token')
            ->where('remember_token', $request->token)
            ->first();

        if (!$user) {
            abort(404);
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();

        return to_route('login')->with('success', 'Password Reseted Successfully');
    }
}
