@extends('layouts.admin')

@section('title', 'Classes Management')

@section('content')

<div class="card">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">

        <div>
            <h1 style="margin: 0 0 5px;">
                Classes Management
            </h1>

            <p style="margin: 0; color: var(--text-secondary);">
                Manage school classes and sections.
            </p>
        </div>

        <a href="{{ route('classes.create') }}" class="btn btn-primary">
            + Add New Class
        </a>

    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($classes as $class)

                    <tr>

                        <td>
                            {{ $class->id }}
                        </td>

                        <td>
                            <strong>
                                {{ $class->name }}
                            </strong>
                        </td>

                        <td>
                            {{ $class->section ?? '—' }}
                        </td>

                        <td>
                            {{ $class->description ?? '—' }}
                        </td>

                        <td>

                            @if ($class->is_active)
                                <span style="color: var(--success); font-weight: bold;">
                                    Active
                                </span>
                            @else
                                <span style="color: var(--danger); font-weight: bold;">
                                    Inactive
                                </span>
                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route('classes.edit', $class) }}"
                                class="btn btn-secondary"
                                style="padding: 7px 12px;"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('classes.destroy', $class) }}"
                                style="display: inline;"
                                onsubmit="return confirm('Are you sure you want to delete this class?');"
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
                            colspan="6"
                            style="text-align: center; padding: 40px; color: var(--text-secondary);"
                        >
                            No classes found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection