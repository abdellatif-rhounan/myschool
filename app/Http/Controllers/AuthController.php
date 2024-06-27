<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('auth.login');
    }

    public function authLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $remember = $request->remember ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect('dashboard');
        } else {
            return redirect()->back()->with('error', 'Wrong Credentials');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    public function register()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required',
        ]);

        $user = new User();

        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('login')->with('success', 'Account Created Successfuly');
    }

    public function forgotPassword()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email Not Found!');
        }

        $user->remember_token = Str::random(30);
        $user->save();

        Mail::to($request->email)->send(new ForgotPasswordMail($user));

        return redirect('login')->with('success', 'Email sent Successfully');
    }

    public function resetPassword($token)
    {
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            abort(404);
        }

        if (Auth::check()) {
            Auth::logout();
        }

        return view('auth.reset_password', ['token' => $user->remember_token]);
    }

    public function postResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $user = User::where('remember_token', $request->token)->first();

        if (!$user) {
            abort(404);
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();

        return redirect('login')->with('success', 'Password Reseted Successfully');
    }
}
