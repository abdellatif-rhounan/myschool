<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

trait ReusableLogic
{
    public function sortData(Request $request): array
    {
        // Sort Infos
        $sortPattern = '/\b(id|firstname|lastname)\b/';
        $directionPattern = '/\b(asc|desc)\b/';

        $sortColumn = preg_match($sortPattern, $request->query('sort', 'id')) ?
            $request->query('sort', 'id') : 'id';

        $sortDirection = preg_match($directionPattern, $request->query('direction', 'desc')) ?
            $request->query('direction', 'desc') : 'desc';

        return [
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ];
    }

    public function filterData(Request $request, $users): void
    {
        if ($request->filled('firstname')) {
            $users = $users->where('firstname', 'LIKE', '%' . $request->query('firstname') . '%');
        }

        if ($request->filled('lastname')) {
            $users = $users->where('lastname', 'LIKE', '%' . $request->query('lastname') . '%');
        }

        if ($request->filled('email')) {
            $users = $users->where('email', 'LIKE', '%' . $request->query('email') . '%');
        }

        if ($request->filled('gender')) {
            $users = $users->where('gender', $request->query('gender'));
        }

        if ($request->filled('status')) {
            $users = $users->where('status', $request->query('status'));
        }

        if ($request->filled('created_by')) {
            $users = $users->where('created_by', $request->query('created_by'));
        }
    }

    public function usersList(Request $request, int $role): array
    {
        // Sort Data By
        $sortInfos = $this->sortData($request);
        [$sortColumn, $sortDirection] = [$sortInfos['sortColumn'], $sortInfos['sortDirection']];

        // Users List
        $users = User::select('id', 'firstname', 'lastname', 'email', 'gender', 'status')
            ->where('role', $role);

        // Filter Data
        $this->filterData($request, $users);

        $users = $users->orderBy($sortColumn, $sortDirection)
            ->paginate(7)
            ->withQueryString();

        return [
            'users' => $users,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ];
    }

    public function usersCreators(int $role)
    {
        $creators = User::select('id', 'firstname', 'lastname')->whereIn(
            'id',
            User::distinct()->where('role', $role)->pluck('created_by')
        )->get();

        return $creators;
    }

    public function storeUser(Request $request, int $role)
    {
        $user = User::create([
            'firstname'  => $request->input('firstname'),
            'lastname'   => $request->input('lastname'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
            'gender'     => $request->input('gender'),
            'role'       => $role,
            'status'     => $request->input('status'),
            'created_by' => Auth::id(),
        ]);

        return $user;
    }

    public function decideToUpdate(Request $request, $user): void
    {
        if ($user->firstname != $request->input('firstname')) {
            $user->firstname = $request->input('firstname');
        }

        if ($user->lastname != $request->input('lastname')) {
            $user->lastname = $request->input('lastname');
        }

        if ($user->email != $request->input('email')) {
            $user->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($user->gender != $request->input('gender')) {
            $user->gender = $request->input('gender');
        }

        if ($user->status != $request->input('status')) {
            $user->status = $request->input('status');
        }
    }
}
