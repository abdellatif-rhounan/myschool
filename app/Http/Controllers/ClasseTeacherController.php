<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\ClasseTeacher;

class ClasseTeacherController extends Controller
{
    public function index(Request $request)
    {
        // Filter Content
        $teachers = User::select('id', 'name')
            ->where('user_type', 2)
            ->get();

        // Assignments
        if ($request->filled('teacher')) {
            $classes_ID = ClasseTeacher::where('user_id', $request->teacher)
                ->pluck('classe_id');

            $classesAssignments = Classe::select('id', 'name')
                ->whereIn('id', $classes_ID)
                ->with('teachers')
                ->paginate(5);
        } else {
            $classesAssignments = Classe::has('teachers')
                ->with('teachers')
                ->select('id', 'name')
                ->paginate(5);
        }

        return view('classes_teachers.index', [
            'teachers' => $teachers,
            'classesAssignments' => $classesAssignments
        ]);
    }

    public function create()
    {
        $classes = Classe::select('id', 'name')->get();

        $teachers = User::select('id', 'name')
            ->where('user_type', 2)
            ->orderBy('name')
            ->get();

        return view('classes_teachers.create', [
            'classes' => $classes,
            'teachers' => $teachers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'teachers' => 'required'
        ]);

        $class = Classe::findOrFail($request->class);

        if ($request->filled('teachers')) {
            foreach ($request->teachers as $teacher) {
                $relation = ClasseTeacher::where('classe_id', $class->id)
                    ->where('user_id', $teacher)
                    ->first();

                if (!$relation) {
                    $class->teachers()->attach($teacher);
                }
            }
        }

        return to_route('classes-teachers.index')->with('success', 'Teachers Assigned To Class Successfully');
    }

    public function show(string $id)
    {
        $class = Classe::findOrFail($id);

        return view('classes_teachers.show', compact('class'));
    }

    public function edit(string $id)
    {
        $class = Classe::findOrFail($id);

        $teachers = User::select('id', 'name')
            ->where('user_type', 2)
            ->orderBy('name')
            ->get();

        return view('classes_teachers.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, string $id)
    {
        $class = Classe::findOrFail($id);
        $class->teachers()->detach();

        if ($request->filled('teachers')) {
            foreach ($request->teachers as $teacher) {
                $class->teachers()->attach($teacher);
            }
        }

        return to_route('classes-teachers.index')->with('success', "Class's Teachers Updated Successfully");
    }

    public function destroy(string $id)
    {
        $class = Classe::findOrFail($id);

        $class->teachers()->detach();

        return to_route('classes-teachers.index')->with('success', "Class's Teachers Deleted Successfully");
    }
}
