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

class TeacherController extends Controller
{
    use ReusableLogic;

    public function index(Request $request): View
    {
        // List Of Teachers
        $data = $this->usersList($request, Role::TEACHER->value);

        // Destructuring Data
        [$teachers, $sortColumn, $sortDirection] = [$data['users'], $data['sortColumn'], $data['sortDirection']];

        // Teachers Created By
        $creators = $this->usersCreators(Role::TEACHER->value);

        return view('admin.teachers.index', compact('teachers', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.teachers.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        // store teacher in DB
        $teacher = $this->storeUser($request, Role::TEACHER->value);

        if (!$teacher) return to_route('teachers.index')->withErrors('fail', 'Could Not Create Teacher! Try Again Later');

        return to_route('teachers.index')->with('success', 'Teacher Created Successfully');
    }

    public function show(User $user): View
    {
        if ($user->role !== Role::TEACHER->value) abort(404);

        return view('admin.teachers.show', compact('user'));
    }

    public function edit(User $user): View
    {
        if ($user->role !== Role::TEACHER->value) abort(404);

        return view('admin.teachers.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== Role::TEACHER->value) abort(404);

        // Validate Request
        app(UpdateUserRequest::class)->validateResolved();

        // Check Old Values with New Values & Update
        $this->decideToUpdate($request, $user);

        $user->save();

        return to_route('teachers.index')->with('success', 'Teacher Updated Successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== Role::TEACHER->value) abort(404);

        $user->delete();

        return to_route('teachers.index')->with('success', 'Teacher Deleted Successfully');
    }
}
