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

class AdminController extends Controller
{
    use ReusableLogic;

    public function index(Request $request): View
    {
        // List Of Admins
        $data = $this->usersList($request, Role::ADMIN->value);

        // Destructuring Data
        [$admins, $sortColumn, $sortDirection] = [$data['users'], $data['sortColumn'], $data['sortDirection']];

        // Admins Created By
        $creators = $this->usersCreators(Role::ADMIN->value);

        return view('admin.admins.index', compact('admins', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        // store admin in DB
        $admin = $this->storeUser($request, Role::ADMIN->value);

        if (!$admin) return to_route('admins.index')->withErrors('fail', 'Could Not Create Admin! Try Again Later');

        return to_route('admins.index')->with('success', 'Admin Created Successfully');
    }

    public function show(User $user): View
    {
        if ($user->role !== Role::ADMIN->value) abort(404);

        return view('admin.admins.show', compact('user'));
    }

    public function edit(User $user): View
    {
        if ($user->role !== Role::ADMIN->value) abort(404);

        return view('admin.admins.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== Role::ADMIN->value) abort(404);

        // Validate Request
        app(UpdateUserRequest::class)->validateResolved();

        // Check Old Values with New Values & Update
        $this->decideToUpdate($request, $user);

        $user->save();

        return to_route('admins.index')->with('success', 'Admin Updated Successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== Role::ADMIN->value) abort(404);

        $user->delete();

        return to_route('admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
