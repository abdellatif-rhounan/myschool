<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('user_type', 1);

        if ($request->input('name')) {
            $users = $users->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->input('email')) {
            $users = $users->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if (!is_null($request->input('status'))) {
            $users = $users->where('status', $request->input('status'));
        }

        $users = $users->orderBy('id', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('admins.index', ['users' => $users]);
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required',
        ]);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->status = $request->status ? 1 : 0;
        $user->user_type = 1;
        $user->save();

        return to_route('admins.index')->with('success', 'Admin Created Successfully');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admins.edit', ['user' => $user]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id),],
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required',
        ]);

        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->status = $request->status ? 1 : 0;
        $user->user_type = 1;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return to_route('admins.index')->with('success', 'Admin Updated Successfully');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        User::destroy($user->id);

        return to_route('admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
