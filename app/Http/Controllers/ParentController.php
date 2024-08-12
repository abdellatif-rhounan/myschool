<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        // List Of Admin Creators
        $parents_creators_ids = User::where('user_type', 4)
            ->distinct()
            ->pluck('created_by');

        $parents_creators = User::select('id', 'name')
            ->whereIn('id', $parents_creators_ids)
            ->get();

        // List Of Parents
        $parents = User::select('id', 'name', 'email', 'status')
            ->where('user_type', 4);

        if ($request->filled('name')) {
            $parents = $parents->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $parents = $parents->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if ($request->filled('status')) {
            $parents = $parents->where('status', $request->input('status'));
        }

        if ($request->filled('created_by')) {
            $parents = $parents->where('created_by', $request->input('created_by'));
        }

        $parents = $parents->orderBy('id', 'desc')
            ->paginate(7)
            ->withQueryString();

        return view('parents.index', ['parents' => $parents, 'parents_creators' => $parents_creators]);
    }

    public function show(User $user)
    {
        return view('parents.show', ['user' => $user]);
    }

    public function create()
    {
        return view('parents.create');
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
        $user->user_type = 4;
        $user->created_by = Auth::user()->id;
        $user->save();

        return to_route('parents.index')->with('success', 'Parent Created Successfully');
    }

    public function edit(User $user)
    {
        return view('parents.edit', ['user' => $user]);
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

        return to_route('parents.index')->with('success', 'Parent Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('parents.index')->with('success', 'Parent Deleted Successfully');
    }
}
