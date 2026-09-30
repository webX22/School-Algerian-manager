@extends('layouts.admin')

@section('title', 'Add Class')

@section('content')

<div class="card" style="max-width: 800px;">

    <h1 style="margin-top: 0;">
        Add New Class
    </h1>

    <p style="color: var(--text-secondary);">
        Create a new school class and section.
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

    <form method="POST" action="{{ route('classes.store') }}">

        @csrf

        <div style="margin-bottom: 18px;">

            <label for="name">
                Class Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Example: 1st Year"
                required
            >

        </div>

        <div style="margin-bottom: 18px;">

            <label for="section">
                Section
            </label>

            <input
                type="text"
                id="section"
                name="section"
                value="{{ old('section') }}"
                placeholder="Example: A"
            >

        </div>

        <div style="margin-bottom: 18px;">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Optional description..."
            >{{ old('description') }}</textarea>

        </div>

        <div style="margin-bottom: 25px;">

            <label style="display: flex; align-items: center; gap: 8px;">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    style="width: auto;"
                    @checked(old('is_active', true))
                >

                Class is active

            </label>

        </div>

        <button type="submit" class="btn btn-primary">
            Create Class
        </button>

        <a
            href="{{ route('classes.index') }}"
            class="btn"
            style="background: #E2E8F0; color: var(--text); margin-left: 8px;"
        >
            Cancel
        </a>

    </form>

</div>

@endsection