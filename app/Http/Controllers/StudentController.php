<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Enums\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\ReusableLogic;

class StudentController extends Controller
{
    use ReusableLogic;

    public function index(Request $request): View
    {
        // List Of Students
        $data = $this->usersList($request, Role::STUDENT->value);

        // Destructuring Data
        [$students, $sortColumn, $sortDirection] = [$data['users'], $data['sortColumn'], $data['sortDirection']];

        // Students Created By
        $creators = $this->usersCreators(Role::STUDENT->value);

        return view('admin.students.index', compact('students', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        // store student in DB
        $student = $this->storeUser($request, Role::STUDENT->value);

        if (!$student) return to_route('students.index')->withErrors('fail', 'Could Not Create Student! Try Again Later');

        return to_route('students.index')->with('success', 'Student Created Successfully');
    }

    public function show(User $user): View
    {
        if ($user->role !== Role::STUDENT->value) abort(404);

        return view('admin.students.show', compact('user'));
    }

    public function edit(User $user): View
    {
        if ($user->role !== Role::STUDENT->value) abort(404);

        return view('admin.students.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== Role::STUDENT->value) abort(404);

        // Validate Request
        app(UpdateUserRequest::class)->validateResolved();

        // Check Old Values with New Values & Update
        $this->decideToUpdate($request, $user);

        $user->save();

        return to_route('students.index')->with('success', 'Student Updated Successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== Role::STUDENT->value) abort(404);

        $user->delete();

        return to_route('students.index')->with('success', 'Student Deleted Successfully');
    }
}
