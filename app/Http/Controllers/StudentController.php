<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

use App\Enums\Gender;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\User;

class StudentController extends Controller
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

        // List Of Students
        $students = User::select('id', 'firstname', 'lastname', 'email', 'gender', 'status')
            ->where('role', Role::STUDENT->value);

        // Filter Infos
        if ($request->filled('firstname')) {
            $students = $students->where('firstname', 'LIKE', '%' . $request->query('firstname') . '%');
        }

        if ($request->filled('lastname')) {
            $students = $students->where('lastname', 'LIKE', '%' . $request->query('lastname') . '%');
        }

        if ($request->filled('email')) {
            $students = $students->where('email', 'LIKE', '%' . $request->query('email') . '%');
        }

        if ($request->filled('gender')) {
            $students = $students->where('gender', $request->query('gender'));
        }

        if ($request->filled('status')) {
            $students = $students->where('status', $request->query('status'));
        }

        if ($request->filled('created_by')) {
            $students = $students->where('created_by', $request->query('created_by'));
        }

        $students = $students->orderBy($sortColumn, $sortDirection)
            ->paginate(7)
            ->withQueryString();

        // Students Created By
        $creators = User::select('id', 'firstname', 'lastname')->whereIn(
            'id',
            User::distinct()->where('role', Role::STUDENT->value)->pluck('created_by')
        )->get();

        return view('admin.students.index', compact('students', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', 'unique:users'],
            'password'  => ['required', 'string', 'min:4', 'max:50', 'confirmed'],
            'gender'    => ['required', Rule::enum(Gender::class)],
            'status'    => [
                'required',
                Rule::in(
                    array_map(
                        fn($case) => $case->value,
                        array_filter(UserStatus::cases(), fn($case) => $case !== UserStatus::VACATION)
                    )
                ),
            ],
        ]);

        $student = User::create([
            'firstname'  => $request->input('firstname'),
            'lastname'   => $request->input('lastname'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
            'gender'     => $request->input('gender'),
            'role'       => Role::STUDENT->value,
            'status'     => $request->input('status'),
            'created_by' => Auth::id(),
        ]);

        if (!$student) return to_route('students.index')->withErrors('fail', 'Could Not Create Student! Try Again Later');

        return to_route('students.index')->with('success', 'Student Created Successfully');
    }

    public function show(User $student): View
    {
        if ($student->role != Role::STUDENT->value) abort(404);

        return view('admin.students.show', compact('student'));
    }

    public function edit(User $student): View
    {
        if ($student->role != Role::STUDENT->value) abort(404);

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        if ($student->role != Role::STUDENT->value) abort(404);

        $request->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', Rule::unique('users')->ignore($student->id)],
            'password'  => ['nullable', 'string', 'min:4', 'max:50', 'confirmed'],
            'gender'    => ['required', Rule::enum(Gender::class)],
            'status'    => [
                'required',
                Rule::in(
                    array_map(
                        fn($case) => $case->value,
                        array_filter(UserStatus::cases(), fn($case) => $case !== UserStatus::VACATION)
                    )
                ),
            ],
        ]);

        if ($student->firstname != $request->input('firstname')) {
            $student->firstname = $request->input('firstname');
        }

        if ($student->lastname != $request->input('lastname')) {
            $student->lastname = $request->input('lastname');
        }

        if ($student->email != $request->input('email')) {
            $student->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $student->password = Hash::make($request->input('password'));
        }

        if ($student->gender != $request->input('gender')) {
            $student->gender = $request->input('gender');
        }

        if ($student->status != $request->input('status')) {
            $student->status = $request->input('status');
        }

        $student->save();

        return to_route('students.index')->with('success', 'Student Updated Successfully');
    }

    public function destroy(User $student): RedirectResponse
    {
        if ($student->role != Role::STUDENT->value) abort(404);

        $student->delete();

        return to_route('students.index')->with('success', 'Student Deleted Successfully');
    }
}
