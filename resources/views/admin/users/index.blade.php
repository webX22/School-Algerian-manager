@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')

<div class="card">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

        <div>
            <h1 style="margin: 0 0 5px;">
                Users Management
            </h1>

            <p style="margin: 0; color: var(--text-secondary);">
                Manage administrators, managers and students.
            </p>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            + Add New User
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Search and Filter --}}

    <form
        method="GET"
        action="{{ route('users.index') }}"
        style="display: flex; gap: 10px; margin-bottom: 25px;"
    >

        <input
            type="text"
            name="search"
            placeholder="Search name or email..."
            value="{{ request('search') }}"
        >

        <select name="role">

            <option value="">
                All Roles
            </option>

            <option
                value="admin"
                @selected(request('role') === 'admin')
            >
                Administrator
            </option>

            <option
                value="gestionnaire"
                @selected(request('role') === 'gestionnaire')
            >
                Gestionnaire
            </option>

            <option
                value="eleve"
                @selected(request('role') === 'eleve')
            >
                Student
            </option>

        </select>

        <button
            type="submit"
            class="btn btn-secondary"
        >
            Search
        </button>

        <a
            href="{{ route('users.index') }}"
            class="btn"
            style="background: #E2E8F0; color: var(--text);"
        >
            Clear
        </a>

    </form>

    {{-- Users Table --}}

    <div style="overflow-x: auto;">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($users as $user)

                    <tr>

                        <td>
                            {{ $user->id }}
                        </td>

                        <td>
                            <strong>
                                {{ $user->name }}
                            </strong>
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            @if ($user->role === 'admin')

                                <span style="color: var(--primary-dark); font-weight: bold;">
                                    Administrator
                                </span>

                            @elseif ($user->role === 'gestionnaire')

                                <span style="color: var(--secondary); font-weight: bold;">
                                    Gestionnaire
                                </span>

                            @elseif ($user->role === 'eleve')

                                <span style="color: var(--success); font-weight: bold;">
                                    Student
                                </span>

                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route('users.edit', $user) }}"
                                class="btn btn-secondary"
                                style="padding: 7px 12px;"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('users.destroy', $user) }}"
                                style="display: inline;"
                                onsubmit="return confirm('Are you sure you want to delete this user?');"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    style="padding: 7px 12px;"
                                >
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            style="text-align: center; padding: 30px; color: var(--text-secondary);"
                        >
                            No users found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

