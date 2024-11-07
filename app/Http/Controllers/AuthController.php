<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return to_route('dashboard');
        }

        return back()->withErrors(['fail' => 'Wrong Credentials'])->onlyInput('email');
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
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['fail' => __($status)]);
    }

    public function resetPassword(string $token): View
    {
        return view('auth.reset_password', compact('token'));
    }

    public function postResetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:4', 'max:50', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? to_route('login')->with('success', __($status))
            : back()->withErrors(['fail' => __($status)]);
    }
}
