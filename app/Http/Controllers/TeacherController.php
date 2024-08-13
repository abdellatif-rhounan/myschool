<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        // List Of Admin Creators
        $teachers_creators_ids = User::where('user_type', 2)
            ->distinct()
            ->pluck('created_by');

        $teachers_creators = User::select('id', 'name')
            ->whereIn('id', $teachers_creators_ids)
            ->get();

        // List Of Teachers
        $teachers = User::select('id', 'name', 'email', 'status')
            ->where('user_type', 2);

        if ($request->filled('name')) {
            $teachers = $teachers->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $teachers = $teachers->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if ($request->filled('status')) {
            $teachers = $teachers->where('status', $request->input('status'));
        }

        if ($request->filled('created_by')) {
            $teachers = $teachers->where('created_by', $request->input('created_by'));
        }

        $teachers = $teachers->orderBy('id', 'desc')
            ->paginate(7)
            ->withQueryString();

        return view('teachers.index', ['teachers' => $teachers, 'teachers_creators' => $teachers_creators]);
    }

    public function show(User $user)
    {
        return view('teachers.show', ['user' => $user]);
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status ? 1 : 0;
        $user->user_type = 2;
        $user->created_by = Auth::user()->id;
        $user->save();

        return to_route('teachers.index')->with('success', 'Teacher Created Successfully');
    }

    public function edit(User $user)
    {
        return view('teachers.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id),],
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status ? 1 : 0;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return to_route('teachers.index')->with('success', 'Teacher Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('teachers.index')->with('success', 'Teacher Deleted Successfully');
    }
}
