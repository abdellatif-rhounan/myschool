<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // List Of Admin Creators
        $students_creators_ids = User::where('user_type', 3)
            ->distinct()
            ->pluck('created_by');

        $students_creators = User::select('id', 'name')
            ->whereIn('id', $students_creators_ids)
            ->get();

        // List Of Students
        $students = User::select('id', 'name', 'email', 'status')
            ->where('user_type', 3);

        if ($request->filled('name')) {
            $students = $students->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $students = $students->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if ($request->filled('status')) {
            $students = $students->where('status', $request->input('status'));
        }

        if ($request->filled('created_by')) {
            $students = $students->where('created_by', $request->input('created_by'));
        }

        $students = $students->orderBy('id', 'desc')
            ->paginate(7)
            ->withQueryString();

        return view('students.index', ['students' => $students, 'students_creators' => $students_creators]);
    }

    public function show(User $user)
    {
        return view('students.show', ['user' => $user]);
    }

    public function create()
    {
        return view('students.create');
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
        $user->user_type = 3;
        $user->created_by = Auth::user()->id;
        $user->save();

        return to_route('students.index')->with('success', 'Student Created Successfully');
    }

    public function edit(User $user)
    {
        return view('students.edit', ['user' => $user]);
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

        return to_route('students.index')->with('success', 'Student Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('students.index')->with('success', 'Student Deleted Successfully');
    }
}
