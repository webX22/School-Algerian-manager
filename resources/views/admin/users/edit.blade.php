@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="card" style="max-width: 800px;">

    <h1 style="margin-top: 0;">
        Edit User
    </h1>

    <p style="color: var(--text-secondary);">
        Update this user's account information and permissions.
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

    <form method="POST" action="{{ route('users.update', $user) }}">

        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label for="name">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
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
                value="{{ old('email', $user->email) }}"
                required
            >
        </div>

        <div style="margin-bottom: 18px;">
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
            @selected(old('role', $user->role) === 'admin')
        >
            Administrator
        </option>

        <option
            value="gestionnaire"
            @selected(old('role', $user->role) === 'gestionnaire')
        >
            Gestionnaire
        </option>

        <option
            value="eleve"
            @selected(old('role', $user->role) === 'eleve')
        >
            Student
        </option>

    </select>

    @error('role')
        <span class="error">{{ $message }}</span>
    @enderror

</div>



        <div style="margin-bottom: 25px;">
            <label for="password">
                New Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Leave empty to keep current password"
            >

            <small style="color: var(--text-secondary);">
                Only enter a password if you want to change it.
            </small>
        </div>

        <button type="submit" class="btn btn-primary">
            Update User
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