@extends('layouts.admin')

@section('title', 'Add Student')

@section('content')

<div class="card">

    <div style="margin-bottom: 25px;">
        <h1 style="margin: 0 0 5px;">
            Add New Student
        </h1>

        <p style="margin: 0; color: var(--text-secondary);">
            Create a student and optionally link an eleve login account.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert-danger" style="margin-bottom: 20px;">
            <strong>Please fix the following errors:</strong>

            <ul style="margin: 10px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('students.store') }}"
    >

        @csrf

        <div class="form-grid">

            {{-- Student Account --}}

            <div>
                <label for="user_id">
                    Student Account
                </label>

                <select
                    id="user_id"
                    name="user_id"
                >
                    <option value="">
                        No account linked
                    </option>

                    @foreach ($users as $user)
                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id') == $user->id)
                        >
                            {{ $user->name }} — {{ $user->email }}
                        </option>
                    @endforeach
                </select>

                <small style="color: var(--text-secondary);">
                    Only available users with the role
                    <strong>eleve</strong> are shown.
                </small>
            </div>

            {{-- Student Code --}}

            <div>
                <label for="student_code">
                    Student Code
                </label>

                <input
                    type="text"
                    id="student_code"
                    name="student_code"
                    value="{{ old('student_code') }}"
                    placeholder="Example: STU-001"
                    required
                >
            </div>

            {{-- First Name --}}

            <div>
                <label for="first_name">
                    First Name
                </label>

                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    value="{{ old('first_name') }}"
                    placeholder="First name"
                    required
                >
            </div>

            {{-- Last Name --}}

            <div>
                <label for="last_name">
                    Last Name
                </label>

                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    value="{{ old('last_name') }}"
                    placeholder="Last name"
                    required
                >
            </div>

            {{-- Date of Birth --}}

            <div>
                <label for="date_of_birth">
                    Date of Birth
                </label>

                <input
                    type="date"
                    id="date_of_birth"
                    name="date_of_birth"
                    value="{{ old('date_of_birth') }}"
                >
            </div>

            {{-- Gender --}}

            <div>
                <label for="gender">
                    Gender
                </label>

                <select
                    id="gender"
                    name="gender"
                >
                    <option value="">
                        Select gender
                    </option>

                    <option
                        value="male"
                        @selected(old('gender') === 'male')
                    >
                        Male
                    </option>

                    <option
                        value="female"
                        @selected(old('gender') === 'female')
                    >
                        Female
                    </option>
                </select>
            </div>

            {{-- Class --}}

            <div>
                <label for="class_id">
                    Class
                </label>

                <select
                    id="class_id"
                    name="class_id"
                    required
                >
                    <option value="">
                        Select class
                    </option>

                    @foreach ($classes as $class)
                        <option
                            value="{{ $class->id }}"
                            @selected(old('class_id') == $class->id)
                        >
                            {{ $class->name }}
                            @if ($class->section)
                                — {{ $class->section }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Active Status --}}

            <div>
                <label for="is_active">
                    Status
                </label>

                <select
                    id="is_active"
                    name="is_active"
                >
                    <option
                        value="1"
                        @selected(old('is_active', '1') == '1')
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        @selected(old('is_active') === '0')
                    >
                        Inactive
                    </option>
                </select>
            </div>

            {{-- Parent Name --}}

            <div>
                <label for="parent_name">
                    Parent Name
                </label>

                <input
                    type="text"
                    id="parent_name"
                    name="parent_name"
                    value="{{ old('parent_name') }}"
                    placeholder="Optional"
                >
            </div>

            {{-- Parent Phone --}}

            <div>
                <label for="parent_phone">
                    Parent Phone
                </label>

                <input
                    type="text"
                    id="parent_phone"
                    name="parent_phone"
                    value="{{ old('parent_phone') }}"
                    placeholder="Optional"
                >
            </div>

        </div>

        <div
            class="form-actions"
            style="margin-top: 25px;"
        >

            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Student
            </button>

            <a
                href="{{ route('students.index') }}"
                class="btn"
                style="background: #E2E8F0; color: var(--text);"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection

