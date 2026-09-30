@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')

<div class="page-header">
    <div>
        <h1>Edit Student</h1>
        <p>Update the student's information and login account.</p>
    </div>

    <a href="{{ route('students.index') }}" class="btn btn-secondary">
        ← Back to Students
    </a>
</div>

<div class="card">

    <form method="POST" action="{{ route('students.update', $student) }}">

        @csrf
        @method('PUT')

        <div class="form-grid">

            {{-- Student Account --}}

            <div class="form-group">

                <label for="user_id">
                    Student Account
                </label>

                <select id="user_id" name="user_id">

                    <option value="">
                        No account linked
                    </option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id', $student->user_id) == $user->id)
                        >
                            {{ $user->name }} — {{ $user->email }}
                        </option>

                    @endforeach

                </select>

                <small style="color: var(--text-secondary);">
                    Only available users with the role
                    <strong>eleve</strong> are shown.
                </small>

                @error('user_id')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Student Code --}}

            <div class="form-group">

                <label for="student_code">
                    Student Code *
                </label>

                <input
                    type="text"
                    id="student_code"
                    name="student_code"
                    value="{{ old('student_code', $student->student_code) }}"
                    required
                >

                @error('student_code')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Class --}}

            <div class="form-group">

                <label for="class_id">
                    Class *
                </label>

                <select id="class_id" name="class_id" required>

                    <option value="">
                        Select Class
                    </option>

                    @foreach($classes as $class)

                        <option
                            value="{{ $class->id }}"
                            @selected(old('class_id', $student->class_id) == $class->id)
                        >
                            {{ $class->name }}

                            @if($class->section)
                                - {{ $class->section }}
                            @endif
                        </option>

                    @endforeach

                </select>

                @error('class_id')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- First Name --}}

            <div class="form-group">

                <label for="first_name">
                    First Name *
                </label>

                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    value="{{ old('first_name', $student->first_name) }}"
                    required
                >

                @error('first_name')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Last Name --}}

            <div class="form-group">

                <label for="last_name">
                    Last Name *
                </label>

                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    value="{{ old('last_name', $student->last_name) }}"
                    required
                >

                @error('last_name')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Date of Birth --}}

            <div class="form-group">

                <label for="date_of_birth">
                    Date of Birth
                </label>

                <input
                    type="date"
                    id="date_of_birth"
                    name="date_of_birth"
                    value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                >

                @error('date_of_birth')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Gender --}}

            <div class="form-group">

                <label for="gender">
                    Gender
                </label>

                <select id="gender" name="gender">

                    <option value="">
                        Select Gender
                    </option>

                    <option
                        value="male"
                        @selected(old('gender', $student->gender) === 'male')
                    >
                        Male
                    </option>

                    <option
                        value="female"
                        @selected(old('gender', $student->gender) === 'female')
                    >
                        Female
                    </option>

                </select>

                @error('gender')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Parent Name --}}

            <div class="form-group">

                <label for="parent_name">
                    Parent / Guardian Name
                </label>

                <input
                    type="text"
                    id="parent_name"
                    name="parent_name"
                    value="{{ old('parent_name', $student->parent_name) }}"
                >

                @error('parent_name')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

            {{-- Parent Phone --}}

            <div class="form-group">

                <label for="parent_phone">
                    Parent / Guardian Phone
                </label>

                <input
                    type="text"
                    id="parent_phone"
                    name="parent_phone"
                    value="{{ old('parent_phone', $student->parent_phone) }}"
                >

                @error('parent_phone')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div>

        </div>

        {{-- Active Status --}}

        <div class="form-group checkbox-group">

            <label>

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', $student->is_active))
                >

                Student is active

            </label>

        </div>

        {{-- Actions --}}

        <div class="form-actions">

            <a
                href="{{ route('students.show', $student) }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection

