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

class GuardianController extends Controller
{
    use ReusableLogic;

    public function index(Request $request): View
    {
        // List Of Guardians
        $data = $this->usersList($request, Role::GUARDIAN->value);

        // Destructuring Data
        [$guardians, $sortColumn, $sortDirection] = [$data['users'], $data['sortColumn'], $data['sortDirection']];

        // Guardians Created By
        $creators = $this->usersCreators(Role::GUARDIAN->value);

        return view('admin.guardians.index', compact('guardians', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.guardians.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        // store guardian in DB
        $guardian = $this->storeUser($request, Role::GUARDIAN->value);

        if (!$guardian) return to_route('guardians.index')->withErrors('fail', 'Could Not Create Guardian! Try Again Later');

        return to_route('guardians.index')->with('success', 'Guardian Created Successfully');
    }

    public function show(User $user): View
    {
        if ($user->role !== Role::GUARDIAN->value) abort(404);

        return view('admin.guardians.show', compact('user'));
    }

    public function edit(User $user): View
    {
        if ($user->role !== Role::GUARDIAN->value) abort(404);

        return view('admin.guardians.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== Role::GUARDIAN->value) abort(404);

        // Validate Request
        app(UpdateUserRequest::class)->validateResolved();

        // Check Old Values with New Values & Update
        $this->decideToUpdate($request, $user);

        $user->save();

        return to_route('guardians.index')->with('success', 'Guardian Updated Successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== Role::GUARDIAN->value) abort(404);

        $user->delete();

        return to_route('guardians.index')->with('success', 'Guardian Deleted Successfully');
    }
}
