<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\ClasseSubject;

class ClasseSubjectController extends Controller
{
    public function index(Request $request)
    {
        // Filter Content
        $subjects = Subject::has('classes')
            ->select('id', 'name')
            ->get();

        // Assignments
        if ($request->filled('subject')) {
            $classes_ID = ClasseSubject::where('subject_id', $request->subject)
                ->pluck('classe_id');

            $classesAssignments = Classe::select('id', 'name')
                ->whereIn('id', $classes_ID)
                ->with('subjects')
                ->paginate(5);
        } else {
            $classesAssignments = Classe::has('subjects')
                ->with('subjects')
                ->select('id', 'name')
                ->paginate(5);
        }

        return view('classes_subjects.index', [
            'subjects' => $subjects,
            'classesAssignments' => $classesAssignments
        ]);
    }

    public function create()
    {
        $classes = Classe::select('id', 'name')->get();

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
            'class' => 'required|string',
            'subjects' => 'required'
        ]);

        $class = Classe::findOrFail($request->class);

        if ($request->filled('subjects')) {
            foreach ($request->subjects as $subject) {
                $relation = ClasseSubject::where('classe_id', $class->id)
                    ->where('subject_id', $subject)
                    ->first();

                if (!$relation) {
                    $class->subjects()->attach($subject);
                }
            }
        }

        return to_route('classes-subjects.index')->with('success', 'Subjects Assigned To Class Successfully');
    }

    public function show(string $id)
    {
        $class = Classe::findOrFail($id);

        return view('classes_subjects.show', compact('class'));
    }

    public function edit(string $id)
    {
        $class = Classe::findOrFail($id);

        $subjects = Subject::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('classes_subjects.edit', compact('class', 'subjects'));
    }

    public function update(Request $request, string $id)
    {
        $class = Classe::findOrFail($id);
        $class->subjects()->detach();

        if ($request->filled('subjects')) {
            foreach ($request->subjects as $subject) {
                $class->subjects()->attach($subject);
            }
        }

        return to_route('classes-subjects.index')->with('success', "Class's Subjects Updated Successfully");
    }

    public function destroy(string $id)
    {
        $class = Classe::findOrFail($id);

        $class->subjects()->detach();

        return to_route('classes-subjects.index')->with('success', "Class's Subjects Deleted Successfully");
    }
}
