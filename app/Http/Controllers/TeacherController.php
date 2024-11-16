<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Enums\Gender;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\User;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        // Sort Infos
        $sortPattern = '/\b(id|firstname|lastname)\b/';
        $directionPattern = '/\b(asc|desc)\b/';

        $sortColumn = preg_match($sortPattern, $request->query('sort', 'id')) ?
            $request->query('sort', 'id') : 'id';
        $sortDirection = preg_match($directionPattern, $request->query('direction', 'desc')) ?
            $request->query('direction', 'desc') : 'desc';

        // List Of Teachers
        $teachers = User::select('id', 'firstname', 'lastname', 'email', 'gender', 'status')
            ->where('role', Role::TEACHER->value);

        // Filter Infos
        if ($request->filled('firstname')) {
            $teachers = $teachers->where('firstname', 'LIKE', '%' . $request->query('firstname') . '%');
        }

        if ($request->filled('lastname')) {
            $teachers = $teachers->where('lastname', 'LIKE', '%' . $request->query('lastname') . '%');
        }

        if ($request->filled('email')) {
            $teachers = $teachers->where('email', 'LIKE', '%' . $request->query('email') . '%');
        }

        if ($request->filled('gender')) {
            $teachers = $teachers->where('gender', $request->query('gender'));
        }

        if ($request->filled('status')) {
            $teachers = $teachers->where('status', $request->query('status'));
        }

        if ($request->filled('created_by')) {
            $teachers = $teachers->where('created_by', $request->query('created_by'));
        }

        $teachers = $teachers->orderBy($sortColumn, $sortDirection)
            ->paginate(7)
            ->withQueryString();

        // Teachers Created By
        $creators = User::select('id', 'firstname', 'lastname')->whereIn(
            'id',
            User::distinct()->where('role', Role::TEACHER->value)->pluck('created_by')
        )->get();

        return view('admin.teachers.index', compact('teachers', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', 'unique:users'],
            'password'  => ['required', 'string', 'min:4', 'max:50', 'confirmed'],
            'gender'    => ['required', Rule::enum(Gender::class)],
            'status'    => ['required', Rule::enum(UserStatus::class)],
        ]);

        $teacher = User::create([
            'firstname'  => $request->input('firstname'),
            'lastname'   => $request->input('lastname'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
            'gender'     => $request->input('gender'),
            'role'       => Role::TEACHER->value,
            'status'     => $request->input('status'),
            'created_by' => Auth::id(),
        ]);

        if (!$teacher) return to_route('teachers.index')->withErrors('fail', 'Could Not Create Teacher! Try Again Later');

        return to_route('teachers.index')->with('success', 'Teacher Created Successfully');
    }

    public function show(User $teacher): View
    {
        if ($teacher->role != Role::TEACHER->value) abort(404);

        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(User $teacher): View
    {
        if ($teacher->role != Role::TEACHER->value) abort(404);

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher): RedirectResponse
    {
        if ($teacher->role != Role::TEACHER->value) abort(404);

        $request->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', Rule::unique('users')->ignore($teacher->id)],
            'password'  => ['nullable', 'string', 'min:4', 'max:50', 'confirmed'],
            'gender'    => ['required', Rule::enum(Gender::class)],
            'status'    => ['required', Rule::enum(UserStatus::class)],
        ]);

        if ($teacher->firstname != $request->input('firstname')) {
            $teacher->firstname = $request->input('firstname');
        }

        if ($teacher->lastname != $request->input('lastname')) {
            $teacher->lastname = $request->input('lastname');
        }

        if ($teacher->email != $request->input('email')) {
            $teacher->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->input('password'));
        }

        if ($teacher->gender != $request->input('gender')) {
            $teacher->gender = $request->input('gender');
        }

        if ($teacher->status != $request->input('status')) {
            $teacher->status = $request->input('status');
        }

        $teacher->save();

        return to_route('teachers.index')->with('success', 'Teacher Updated Successfully');
    }

    public function destroy(User $teacher): RedirectResponse
    {
        if ($teacher->role != Role::TEACHER->value) abort(404);

        $teacher->delete();

        return to_route('teachers.index')->with('success', 'Teacher Deleted Successfully');
    }
}
