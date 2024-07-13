<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    public function index(Request $request)
    {
        // Admins Creators of Classes
        $admins_ids = Classe::select('created_by')->distinct()->get();

        $admins = User::select('id', 'name')
            ->whereIn('id', $admins_ids)->get();

        // Classes List
        $classes = Classe::join('users', 'users.id', '=', 'classes.created_by')
            ->select('classes.id', 'classes.name', 'classes.status', 'users.name AS created_by_user');

        if ($request->input('name')) {
            $classes = $classes->where('classes.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if (!is_null($request->input('status'))) {
            $classes = $classes->where('classes.status', $request->input('status'));
        }

        if ($request->input('created_by')) {
            $classes = $classes->where('classes.created_by', $request->input('created_by'));
        }

        $classes = $classes->paginate(8)
            ->withQueryString();

        return view('classes.index', ['classes' => $classes, 'admins' => $admins]);
    }

    public function show(Classe $class)
    {
        return view('classes.show', ['class' => $class]);
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150|unique:classes',
            'status' => 'required',
        ]);

        $user = new Classe();
        $user->name = trim($request->name);
        $user->status = $request->status ? 1 : 0;
        $user->created_by = Auth::user()->id;
        $user->save();

        return to_route('classes.index')->with('success', 'Class Created Successfully');
    }

    public function edit(Classe $class)
    {
        return view('classes.edit', ['class' => $class]);
    }

    public function update(Request $request, Classe $class)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('classes')->ignore($class->id)],
            'status' => 'required',
        ]);

        $class->name = trim($request->name);
        $class->status = $request->status ? 1 : 0;
        $class->save();

        return to_route('classes.index')->with('success', 'Class Updated Successfully');
    }

    public function destroy(Classe $class)
    {
        $class->delete();

        return to_route('classes.index')->with('success', 'Class Deleted Successfully');
    }
}
