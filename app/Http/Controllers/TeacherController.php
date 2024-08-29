<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use App\Models\ClasseSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\ClasseTeacher;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        // List Of Admin Creators
        $teachers_creators_ids = User::where('user_type', 2)
            ->distinct()
            ->pluck('created_by');

        $teachers_creators = User::select('id', 'name')
            ->whereIn('id', $teachers_creators_ids)
            ->get();

        // List Of Teachers
        $teachers = User::select('id', 'name', 'email', 'status')
            ->where('user_type', 2);

        if ($request->filled('name')) {
            $teachers = $teachers->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $teachers = $teachers->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }

        if ($request->filled('status')) {
            $teachers = $teachers->where('status', $request->input('status'));
        }

        if ($request->filled('created_by')) {
            $teachers = $teachers->where('created_by', $request->input('created_by'));
        }

        $teachers = $teachers->orderBy('id', 'desc')
            ->paginate(7)
            ->withQueryString();

        return view('teachers.index', ['teachers' => $teachers, 'teachers_creators' => $teachers_creators]);
    }

    public function show(User $user)
    {
        return view('teachers.show', ['user' => $user]);
    }

    public function create()
    {
        return view('teachers.create');
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
        $user->user_type = 2;
        $user->created_by = Auth::user()->id;
        $user->save();

        return to_route('teachers.index')->with('success', 'Teacher Created Successfully');
    }

    public function edit(User $user)
    {
        return view('teachers.edit', ['user' => $user]);
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

        return to_route('teachers.index')->with('success', 'Teacher Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('teachers.index')->with('success', 'Teacher Deleted Successfully');
    }

    public function myClassesSubjects(Request $request)
    {
        // Assignments
        $teacher_classes_ID = ClasseTeacher::where('user_id', Auth::user()->id)
            ->pluck('classe_id');

        if ($request->filled('subject')) {
            $classes_ID = ClasseSubject::where('subject_id', $request->subject)
                ->whereIn('classe_id', $teacher_classes_ID)
                ->pluck('classe_id');

            $classesAssignments = Classe::select('id', 'name')
                ->whereIn('id', $classes_ID)
                ->with('subjects')
                ->paginate(5);
        } else {
            $classesAssignments = Classe::with('subjects')
                ->select('id', 'name')
                ->whereIn('id', $teacher_classes_ID)
                ->paginate(5);
        }

        // Filter Content
        $subjectsID = ClasseSubject::whereIn('classe_id', $teacher_classes_ID)
            ->distinct()
            ->pluck('subject_id');

        $subjects = Subject::select('id', 'name')
            ->whereIn('id', $subjectsID)
            ->get();

        return view('teachers.my_classes_subjects', [
            'classesAssignments' => $classesAssignments,
            'subjects' => $subjects
        ]);
    }

    public function myClassesStudents(Request $request)
    {
        // Assignments
        $teacher_classes_ID = ClasseTeacher::where('user_id', Auth::user()->id)
            ->pluck('classe_id');

        $classes = Classe::select('id', 'name')
            ->whereIn('id', $teacher_classes_ID)
            ->orderBy('name')
            ->get();

        if ($request->filled('class')) {
            $classesAssignments = Classe::with('students')
                ->select('id', 'name')
                ->where('id', $request->class)
                ->paginate(1);
        } else {
            $classesAssignments = Classe::with('students')
                ->select('id', 'name')
                ->whereIn('id', $teacher_classes_ID)
                ->orderBy('name')
                ->paginate(5);
        }

        return view('teachers.my_classes_students', compact('classes', 'classesAssignments'));
    }
}
