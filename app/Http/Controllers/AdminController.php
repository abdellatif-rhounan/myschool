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

class AdminController extends Controller
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

        // List Of Admins
        $admins = User::select('id', 'firstname', 'lastname', 'email', 'gender', 'status')
            ->where('role', Role::ADMIN->value);

        // Filter Infos
        if ($request->filled('firstname')) {
            $admins = $admins->where('firstname', 'LIKE', '%' . $request->query('firstname') . '%');
        }

        if ($request->filled('lastname')) {
            $admins = $admins->where('lastname', 'LIKE', '%' . $request->query('lastname') . '%');
        }

        if ($request->filled('email')) {
            $admins = $admins->where('email', 'LIKE', '%' . $request->query('email') . '%');
        }

        if ($request->filled('gender')) {
            $admins = $admins->where('gender', $request->query('gender'));
        }

        if ($request->filled('status')) {
            $admins = $admins->where('status', $request->query('status'));
        }

        if ($request->filled('created_by')) {
            $admins = $admins->where('created_by', $request->query('created_by'));
        }

        $admins = $admins->orderBy($sortColumn, $sortDirection)
            ->paginate(7)
            ->withQueryString();

        // Admins Created By
        $creators = User::select('id', 'firstname', 'lastname')->whereIn(
            'id',
            User::distinct()->where('role', Role::ADMIN->value)->pluck('created_by')
        )->get();

        return view('admin.admins.index', compact('admins', 'creators', 'sortColumn', 'sortDirection'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
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

        $admin = User::create([
            'firstname'  => $request->input('firstname'),
            'lastname'   => $request->input('lastname'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
            'gender'     => $request->input('gender'),
            'role'       => Role::ADMIN->value,
            'status'     => $request->input('status'),
            'created_by' => Auth::id(),
        ]);

        if (!$admin) return to_route('admins.index')->withErrors('fail', 'Could Not Create Admin! Try Again Later');

        return to_route('admins.index')->with('success', 'Admin Created Successfully');
    }

    public function show(User $admin): View
    {
        if ($admin->role != Role::ADMIN->value) abort(404);

        return view('admin.admins.show', compact('admin'));
    }

    public function edit(User $admin): View
    {
        if ($admin->role != Role::ADMIN->value) abort(404);

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin): RedirectResponse
    {
        if ($admin->role != Role::ADMIN->value) abort(404);

        $request->validate([
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', Rule::unique('users')->ignore($admin->id)],
            'password'  => ['nullable', 'string', 'min:4', 'max:50', 'confirmed'],
            'gender'    => ['required', Rule::enum(Gender::class)],
            'status'    => ['required', Rule::enum(UserStatus::class)],
        ]);

        if ($admin->firstname != $request->input('firstname')) {
            $admin->firstname = $request->input('firstname');
        }

        if ($admin->lastname != $request->input('lastname')) {
            $admin->lastname = $request->input('lastname');
        }

        if ($admin->email != $request->input('email')) {
            $admin->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        if ($admin->gender != $request->input('gender')) {
            $admin->gender = $request->input('gender');
        }

        if ($admin->status != $request->input('status')) {
            $admin->status = $request->input('status');
        }

        $admin->save();

        return to_route('admins.index')->with('success', 'Admin Updated Successfully');
    }

    public function destroy(User $admin): RedirectResponse
    {
        if ($admin->role != Role::ADMIN->value) abort(404);

        $admin->delete();

        return to_route('admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
