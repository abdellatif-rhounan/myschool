<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseStudentController extends Controller
{
    public function index(Request $request)
    {
        // Filter Content
        $classes = Classe::select('id', 'name')->get();

        if ($request->filled('class')) {
            $classesAssignments = Classe::with('students')
                ->select('id', 'name')
                ->where('id', $request->class)
                ->paginate(1);
        } else {
            $classesAssignments = Classe::with('students')
                ->select('id', 'name')
                ->paginate(5);
        }

        return view('classes_students.index', compact('classes', 'classesAssignments'));
    }

    public function create()
    {
        $classes = Classe::select('id', 'name')->get();

        $students = User::select('id', 'name')
            ->where('user_type', 3)
            ->orderBy('name')
            ->get();

        return view('classes_students.create', compact('classes', 'students'));
    }

    public function show(string $id)
    {
        $class = Classe::findOrFail($id);

        return view('classes_students.show', compact('class'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'students' => 'required'
        ]);

        $class = Classe::findOrFail($request->class);

        if ($request->filled('students')) {
            foreach ($request->students as $student) {
                $user = User::where('id', $student)
                    ->first();

                if (!$user->classe_id) {
                    $user->classe_id = $class->id;
                    $user->save();
                }
            }
        }

        return to_route('classes-students.index')->with('success', 'Students Assigned To Class Successfully');
    }

    public function edit(string $id)
    {
        $class = Classe::findOrFail($id);

        $students = User::select('id', 'name')
            ->where('user_type', 3)
            ->orderBy('name')
            ->get();

        return view('classes_students.edit', compact('class', 'students'));
    }

    public function update(Request $request, string $id)
    {
        $class = Classe::findOrFail($id);

        $prev_students = $class->students;

        foreach ($prev_students as $std) {
            $std->classe_id = null;
            $std->save();
        }

        if ($request->filled('students')) {
            foreach ($request->students as $student) {
                $user = User::where('id', $student)
                    ->first();
                $user->classe_id = $class->id;
                $user->save();
            }
        }

        return to_route('classes-students.index')->with('success', "Class's Students Updated Successfully");
    }

    public function destroy(string $id)
    {
        $class = Classe::findOrFail($id);

        $prev_students = $class->students;

        foreach ($prev_students as $std) {
            $std->classe_id = null;
            $std->save();
        }

        return to_route('classes-students.index')->with('success', "Class's Students Deleted Successfully");
    }
}
