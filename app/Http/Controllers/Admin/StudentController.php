<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['schoolClass', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->latest()->get();

        $classes = SchoolClass::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.students.index',
            compact('students', 'classes')
        );
    }

    public function create()
    {
        $classes = SchoolClass::where('is_active', true)
            ->orderBy('name')
            ->get();

        $users = User::where('role', 'eleve')
            ->whereDoesntHave('student')
            ->orderBy('name')
            ->get();

        return view(
            'admin.students.create',
            compact('classes', 'users')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'nullable',
                'exists:users,id',
                'unique:students,user_id',
            ],

            'student_code' => [
                'required',
                'string',
                'max:50',
                'unique:students,student_code',
            ],

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'in:male,female',
            ],

            'class_id' => [
                'required',
                'exists:school_classes,id',
            ],

            'parent_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'parent_phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (! empty($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);

            if ($user->role !== 'eleve') {
                abort(
                    422,
                    'Only eleve users can be linked to a student.'
                );
            }
        }

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load([
            'schoolClass',
            'user',
        ]);

        return view(
            'admin.students.show',
            compact('student')
        );
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::where('is_active', true)
            ->orderBy('name')
            ->get();

        $users = User::where('role', 'eleve')
            ->where(function ($query) use ($student) {
                $query->whereDoesntHave('student')
                    ->orWhere('id', $student->user_id);
            })
            ->orderBy('name')
            ->get();

        return view(
            'admin.students.edit',
            compact('student', 'classes', 'users')
        );
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'user_id' => [
                'nullable',
                'exists:users,id',
                'unique:students,user_id,' . $student->id,
            ],

            'student_code' => [
                'required',
                'string',
                'max:50',
                'unique:students,student_code,' . $student->id,
            ],

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'in:male,female',
            ],

            'class_id' => [
                'required',
                'exists:school_classes,id',
            ],

            'parent_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'parent_phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (! empty($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);

            if ($user->role !== 'eleve') {
                abort(
                    422,
                    'Only eleve users can be linked to a student.'
                );
            }
        }

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->reservations()->exists()) {
            return redirect()
                ->route('students.index')
                ->with(
                    'error',
                    'This student cannot be deleted because they have reservations.'
                );
        }

        $student->delete();

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }
}

