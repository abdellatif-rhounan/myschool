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
            return to_route('dashboard');
        }

        return view('auth.login');
    }

    public function authLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:8|max:50'
        ]);

        if (Auth::attempt(
            [
                'email' => $request->email,
                'password' => $request->password
            ],
            $request->boolean('remember')
        )) {
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

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
        ]);

        $user = User::select('id', 'name', 'remember_token')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email Not Found!');
        }

        $user->remember_token = Str::random(30);
        $user->save();

        Mail::to($request->email)
            ->send(new ForgotPasswordMail(
                $user->name,
                $user->remember_token
            ));

        return to_route('login')->with('success', 'Email Sent Successfully');
    }

    public function resetPassword(User $user)
    {
        return view('auth.reset_password', ['remember_token' => $user->remember_token]);
    }

    public function postResetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|max:50|confirmed'
        ]);

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();

        return to_route('login')->with('success', 'Password Reseted Successfully');
    }
}
