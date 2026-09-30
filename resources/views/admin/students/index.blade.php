@extends('layouts.admin')

@section('title', 'Students Management')

@section('content')

<div class="page-header">
    <div>
        <h1>Students Management</h1>
        <p>Manage students registered in the school restaurant system.</p>
    </div>

    <a href="{{ route('students.create') }}" class="btn btn-primary">
        + Add Student
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">

    <form method="GET" action="{{ route('students.index') }}" class="filter-form">

        <div class="form-group">
            <label for="search">Search</label>
            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Code, first name or last name"
            >
        </div>

        <div class="form-group">
            <label for="class_id">Class</label>

            <select id="class_id" name="class_id">
                <option value="">All Classes</option>

                @foreach($classes as $class)
                    <option
                        value="{{ $class->id }}"
                        @selected(request('class_id') == $class->id)
                    >
                        {{ $class->name }}
                        @if($class->section)
                            - {{ $class->section }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                Search
            </button>

            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>

    </form>

</div>

<div class="card">

    <div class="card-header">
        <div>
            <h2>Students</h2>
            <span>{{ $students->count() }} student(s)</span>
        </div>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Code</th>
                    <th>Student</th>
                    <th>Gender</th>
                    <th>Class</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($students as $student)

                    <tr>

                        <td>
                            <strong>{{ $student->student_code }}</strong>
                        </td>

                        <td>
                            {{ $student->first_name }}
                            {{ $student->last_name }}
                        </td>

                        <td>
                            {{ $student->gender ? ucfirst($student->gender) : '—' }}
                        </td>

                        <td>
                            {{ $student->schoolClass->name }}

                            @if($student->schoolClass->section)
                                <small>
                                    - {{ $student->schoolClass->section }}
                                </small>
                            @endif
                        </td>

                        <td>
                            {{ $student->parent_name ?? '—' }}
                        </td>

                        <td>
                            @if($student->is_active)
                                <span class="badge badge-success">
                                    Active
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('students.show', $student) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('students.edit', $student) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('students.destroy', $student) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this student?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            No students found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection