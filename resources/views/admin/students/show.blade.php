@extends('layouts.admin')

@section('title', 'Student Details')

@section('content')

<div class="page-header">
    <div>
        <h1>Student Details</h1>
        <p>View complete information about this student.</p>
    </div>

    <div class="action-buttons">
        <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
            Edit Student
        </a>

        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            ← Back to Students
        </a>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <div>
            <h2>
                {{ $student->first_name }} {{ $student->last_name }}
            </h2>

            <span>
                Student Code: {{ $student->student_code }}
            </span>
        </div>

        @if($student->is_active)
            <span class="badge badge-success">Active</span>
        @else
            <span class="badge badge-danger">Inactive</span>
        @endif
    </div>

    <div class="form-grid">

        <div class="form-group">
            <label>Student Code</label>
            <div class="detail-value">
                {{ $student->student_code }}
            </div>
        </div>

        <div class="form-group">
            <label>First Name</label>
            <div class="detail-value">
                {{ $student->first_name }}
            </div>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <div class="detail-value">
                {{ $student->last_name }}
            </div>
        </div>

        <div class="form-group">
            <label>Class</label>
            <div class="detail-value">
                {{ $student->schoolClass->name }}

                @if($student->schoolClass->section)
                    - {{ $student->schoolClass->section }}
                @endif
            </div>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <div class="detail-value">
                {{ $student->date_of_birth?->format('d/m/Y') ?? '—' }}
            </div>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div class="detail-value">
                {{ $student->gender ? ucfirst($student->gender) : '—' }}
            </div>
        </div>

        <div class="form-group">
            <label>Parent / Guardian</label>
            <div class="detail-value">
                {{ $student->parent_name ?? '—' }}
            </div>
        </div>

        <div class="form-group">
            <label>Parent / Guardian Phone</label>
            <div class="detail-value">
                {{ $student->parent_phone ?? '—' }}
            </div>
        </div>

    </div>

</div>

@endsection