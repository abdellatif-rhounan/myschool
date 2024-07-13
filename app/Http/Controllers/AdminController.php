<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'role_user:admin'
        ];
    }

    public function index(Request $request)
    {
        // List Of Admin Creators
        $admins_creators_ids = User::select('created_by')->distinct()->get();

        $admins_creators = User::select('id', 'name')
            ->whereIn('id', $admins_creators_ids)
            ->get();

        // List Of Admins
        $users = User::select('id', 'name', 'email', 'status')
            ->where('user_type', 1);

        if ($request->input('name')) {
            $users = $users->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->input('email')) {
            $users = $users->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if (!is_null($request->input('status'))) {
            $users = $users->where('status', $request->input('status'));
        }

        if ($request->input('created_by')) {
            $users = $users->where('created_by', $request->input('created_by'));
        }

        $users = $users->orderBy('id', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('admins.index', ['users' => $users, 'admins_creators' => $admins_creators]);
    }

    public function show(User $user)
    {
        return view('admins.show', ['user' => $user]);
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
        $user->created_by = Auth::user()->id;
        $user->save();

        return to_route('admins.index')->with('success', 'Admin Created Successfully');
    }

    public function edit(User $user)
    {
        return view('admins.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id),],
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required',
        ]);

        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->status = $request->status ? 1 : 0;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return to_route('admins.index')->with('success', 'Admin Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
