@extends('layouts.admin')

@section('title', 'Add User')

@section('content')

<div class="card" style="max-width: 800px;">

    <h1 style="margin-top: 0;">
        Add New User
    </h1>

    <p style="color: var(--text-secondary);">
        Create a new administrator, teacher, student, or parent account.
    </p>

    @if ($errors->any())
        <div class="alert-danger">
            <strong>Please fix the following errors:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">

        @csrf

        <div style="margin-bottom: 18px;">
            <label for="name">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter full name"
                required
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter email address"
                required
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 8 characters"
                required
            >
        </div>

        <div style="margin-bottom: 25px;">
            <label for="role">
                Role
            </label>

            
<div class="form-group">

    <label for="role">
       
    </label>

    <select id="role" name="role" required>

        <option value="">
            Select a role
        </option>

        <option
            value="admin"
            @selected(old('role') === 'admin')
        >
            Administrator
        </option>

        <option
            value="gestionnaire"
            @selected(old('role') === 'gestionnaire')
        >
            Gestionnaire
        </option>

        <option
            value="eleve"
            @selected(old('role') === 'eleve')
        >
            Student
        </option>

    </select>

    @error('role')
        <span class="error">{{ $message }}</span>
    @enderror

</div>



        <button type="submit" class="btn btn-primary">
            Create User
        </button>

        <a
            href="{{ route('users.index') }}"
            class="btn"
            style="background: #E2E8F0; color: var(--text); margin-left: 8px;"
        >
            Cancel
        </a>

    </form>

</div>

@endsection