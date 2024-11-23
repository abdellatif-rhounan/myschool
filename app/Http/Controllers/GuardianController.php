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

class GuardianController extends Controller
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

        // List Of Guardians
        $guardians = User::select('id', 'firstname', 'lastname', 'email', 'gender', 'status')
            ->where('role', Role::GUARDIAN->value);

        // Filter Infos
        if ($request->filled('firstname')) {
            $guardians = $guardians->where('firstname', 'LIKE', '%' . $request->query('firstname') . '%');
        }

        if ($request->filled('lastname')) {
            $guardians = $guardians->where('lastname', 'LIKE', '%' . $request->query('lastname') . '%');
        }

        if ($request->filled('email')) {
            $guardians = $guardians->where('email', 'LIKE', '%' . $request->query('email') . '%');
        }

        if ($request->filled('gender')) {
            $guardians = $guardians->where('gender', $request->query('gender'));
        }

        if ($request->filled('status')) {
            $guardians = $guardians->where('status', $request->query('status'));
        }

        if ($request->filled('created_by')) {
            $guardians = $guardians->where('created_by', $request->query('created_by'));
        }

        $guardians = $guardians->orderBy($sortColumn, $sortDirection)
            ->paginate(7)
            ->withQueryString();

        // Guardians Created By
        $creators = User::select('id', 'firstname', 'lastname')->whereIn(
            'id',
            User::distinct()->where('role', Role::GUARDIAN->value)->pluck('created_by')
        )->get();

        return view('admin.guardians.index', compact('guardians', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.guardians.create');
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

        $guardian = User::create([
            'firstname'  => $request->input('firstname'),
            'lastname'   => $request->input('lastname'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
            'gender'     => $request->input('gender'),
            'role'       => Role::GUARDIAN->value,
            'status'     => $request->input('status'),
            'created_by' => Auth::id(),
        ]);

        if (!$guardian) return to_route('guardians.index')->withErrors('fail', 'Could Not Create Guardian! Try Again Later');

        return to_route('guardians.index')->with('success', 'Guardian Created Successfully');
    }

    public function show(User $guardian): View
    {
        if ($guardian->role != Role::GUARDIAN->value) abort(404);

        return view('admin.guardians.show', compact('guardian'));
    }

    public function edit(User $guardian): View
    {
        if ($guardian->role != Role::GUARDIAN->value) abort(404);

        return view('admin.guardians.edit', compact('guardian'));
    }

    public function update(Request $request, User $guardian): RedirectResponse
    {
        if ($guardian->role != Role::GUARDIAN->value) abort(404);

        $request->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', Rule::unique('users')->ignore($guardian->id)],
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

        if ($guardian->firstname != $request->input('firstname')) {
            $guardian->firstname = $request->input('firstname');
        }

        if ($guardian->lastname != $request->input('lastname')) {
            $guardian->lastname = $request->input('lastname');
        }

        if ($guardian->email != $request->input('email')) {
            $guardian->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $guardian->password = Hash::make($request->input('password'));
        }

        if ($guardian->gender != $request->input('gender')) {
            $guardian->gender = $request->input('gender');
        }

        if ($guardian->status != $request->input('status')) {
            $guardian->status = $request->input('status');
        }

        $guardian->save();

        return to_route('guardians.index')->with('success', 'Guardian Updated Successfully');
    }

    public function destroy(User $guardian): RedirectResponse
    {
        if ($guardian->role != Role::GUARDIAN->value) abort(404);

        $guardian->delete();

        return to_route('guardians.index')->with('success', 'Guardian Deleted Successfully');
    }
}
