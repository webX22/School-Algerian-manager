<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $query = SchoolClass::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'active'
            );
        }

        $classes = $query
            ->orderBy('name')
            ->orderBy('section')
            ->paginate(15)
            ->withQueryString();

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        SchoolClass::create($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load('students');

        return view('admin.classes.show', compact('schoolClass'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        return view('admin.classes.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $schoolClass->update($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }


public function destroy(SchoolClass $schoolClass)
{
    if ($schoolClass->students()->exists()) {
        return redirect()
            ->route('classes.index')
            ->with(
                'error',
                'This class cannot be deleted because it has students.'
            );
    }

    $schoolClass->delete();

    return redirect()
        ->route('classes.index')
        ->with(
            'success',
            'Class deleted successfully.'
        );
}


}