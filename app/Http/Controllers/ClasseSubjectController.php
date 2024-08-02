<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClasseSubjectController extends Controller
{
    public function index()
    {
        $classes = Classe::has('subjects')
            ->with('subjects')
            ->select('id', 'name')
            ->get();

        $subjects = Subject::has('classes')
            ->select('id', 'name')
            ->get();

        return view('classes_subjects.index', [
            'classes' => $classes,
            'subjects' => $subjects
        ]);
    }

    public function create()
    {
        $classes = Classe::select('id', 'name')
            ->orderBy('name')
            ->get();

        $subjects = Subject::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('classes_subjects.create', [
            'classes' => $classes,
            'subjects' => $subjects
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string',        // display Error Not Working!!
            'status' => 'required|string'
        ]);

        $class = Classe::findOrFail($request->class);
        $status = $request->status ? 1 : 0;
        $user = Auth::user()->id;

        foreach ($request->subjects as $subject) {
            $class->subjects()->attach(
                $subject,
                [
                    'status' => $status,
                    'created_by' => $user
                ]
            );
        }

        return to_route('classes-subjects.index')->with('success', 'Subjects Assigned To Class Successfully');
    }

    public function show(string $id)
    {
        return view('classes_subjects.show');
    }

    public function edit(string $id)
    {
        return view('classes_subjects.edit');
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
