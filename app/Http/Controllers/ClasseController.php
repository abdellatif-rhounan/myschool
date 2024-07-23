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
        $admins_ids = Classe::distinct()->pluck('created_by');

        $admins = User::select('id', 'name')
            ->whereIn('id', $admins_ids)
            ->get();

        // Classes List
        $classes = Classe::join('users', 'users.id', '=', 'classes.created_by')
            ->select('classes.id', 'classes.name', 'classes.status', 'users.name AS created_by_user');

        if ($request->filled('name')) {
            $classes = $classes->where('classes.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->filled('status')) {
            $classes = $classes->where('classes.status', $request->input('status'));
        }

        if ($request->filled('created_by')) {
            $classes = $classes->where('classes.created_by', $request->input('created_by'));
        }

        $classes = $classes->paginate(7)->withQueryString();

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
            'name' => 'required|string|max:255|unique:classes',
            'status' => 'required',
        ]);

        $class = new Classe();
        $class->name = trim($request->name);
        $class->status = $request->status ? 1 : 0;
        $class->created_by = Auth::user()->id;
        $class->save();

        return to_route('classes.index')->with('success', 'Class Created Successfully');
    }

    public function edit(Classe $class)
    {
        return view('classes.edit', ['class' => $class]);
    }

    public function update(Request $request, Classe $class)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('classes')->ignore($class->id)],
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
