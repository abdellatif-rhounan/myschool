<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('profile.change_password');
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'old-password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($request->input('old-password'), $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password Successfully Updated');
        } else {
            return redirect()->back()->with('error', 'Old Password Is Incorrect');
        }
    }
}
