<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $user = User::findOrFail(Auth::user()->id);
        $type = $user->user_type;

        switch ($type) {
            case 1:
                $module = 'admins';
                break;
            case 2:
                $module = 'teachers';
                break;
            case 3:
                $module = 'students';
                break;
            case 4:
                $module = 'parents';
                break;
        }

        return view("$module.profile", compact('user'));
    }

    public function editProfile()
    {
        $user = User::findOrFail(Auth::user()->id);
        $type = $user->user_type;

        switch ($type) {
            case 1:
                $module = 'admins';
                break;
            case 2:
                $module = 'teachers';
                break;
            case 3:
                $module = 'students';
                break;
            case 4:
                $module = 'parents';
                break;
        }

        return view("$module.edit_profile", compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id),],
            'status' => 'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status ? 1 : 0;

        $user->save();

        return to_route('profile')->with('success', 'Profile Updated Successfully');
    }

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
