<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Mail\ForgotPasswordMail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:4', 'max:50'],
            'user-type' => ['required', Rule::enum(UserType::class)]
        ]);

        $remember = $request->boolean('remember');
        $guard = $request->input('user-type');

        if (Auth::guard($guard)->attempt($request->only('email', 'password'), $remember)) {
            $request->session()->regenerate();

            return to_route('dashboard.' . $guard);
        } else {
            return back()
                ->with('error', 'Wrong Credentials')
                ->onlyInput('email');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'user-type' => ['required', Rule::enum(UserType::class)]
        ]);

        $user = rightModel($request->input('user-type'))::select('id', 'name', 'remember_token')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Email Not Found!')->onlyInput('email');
        }

        $user->remember_token = Str::random(30);
        $user->save();

        Mail::to($request->email)
            ->send(new ForgotPasswordMail(
                $user->name,
                $user->remember_token,
                $request->input('user-type')
            ));

        return to_route('login')->with('success', 'Email Sent Successfully');
    }

    public function resetPassword(UserType $user_type, string $remember_token): View
    {
        $user = rightModel($user_type->value)::select('id')
            ->where('remember_token', $remember_token)
            ->first();

        if (!$user) abort(404);

        return view('auth.reset_password', compact('remember_token'));
    }

    public function postResetPassword(Request $request, UserType $user_type, string $remember_token): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:4', 'max:50', 'confirmed']
        ]);

        $user = rightModel($user_type->value)::select('id', 'password', 'remember_token')
            ->where('remember_token', $remember_token)
            ->first();

        if (!$user) abort(404);

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();

        return to_route('login')->with('success', 'Password Reseted Successfully');
    }
}
