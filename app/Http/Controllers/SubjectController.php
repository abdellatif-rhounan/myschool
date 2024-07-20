<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        // Admins Creators of Subjects
        $admins_ids = Subject::select('created_by')
            ->distinct()
            ->get();

        $admins = User::select('id', 'name')
            ->whereIn('id', $admins_ids)
            ->get();

        // Subject List
        $subjects = Subject::join('users', 'users.id', '=', 'subjects.created_by')
            ->select('subjects.id', 'subjects.name', 'subjects.type', 'subjects.status', 'users.name AS created_by_user');

        if ($request->input('name')) {
            $subjects = $subjects->where('subjects.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->input('type')) {
            $subjects = $subjects->where('subjects.type', $request->input('type'));
        }

        if (!is_null($request->input('status'))) {
            $subjects = $subjects->where('subjects.status', $request->input('status'));
        }

        if ($request->input('created_by')) {
            $subjects = $subjects->where('subjects.created_by', $request->input('created_by'));
        }

        $subjects = $subjects->paginate(8)
            ->withQueryString();

        return view('subjects.index', ['subjects' => $subjects, 'admins' => $admins]);
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'type' => 'required|string|max:150',
            'status' => 'required',
        ]);

        $subject = new Subject();
        $subject->name = trim($request->name);
        $subject->type = trim($request->type);
        $subject->status = $request->status ? 1 : 0;
        $subject->created_by = Auth::user()->id;
        $subject->save();

        return to_route('subjects.index')->with('success', 'Subject Created Successfully');
    }

    public function show(Subject $subject)
    {
        return view('subjects.show', ['subject' => $subject]);
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', ['subject' => $subject]);
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('subjects')->ignore($subject->id)],
            'type' => 'required',
            'status' => 'required',
        ]);

        $subject->name = trim($request->name);
        $subject->type = $request->type;
        $subject->status = $request->status ? 1 : 0;
        $subject->save();

        return to_route('subjects.index')->with('success', 'Subject Updated Successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return to_route('subjects.index')->with('success', 'Subject Deleted Successfully');
    }
}
