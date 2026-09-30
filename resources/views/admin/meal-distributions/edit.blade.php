@extends('layouts.admin')

@section('title', 'Edit Meal Presence')

@section('content')

@php
    $distributionRoute = auth()->user()->role === 'admin'
        ? 'admin.meal-distributions'
        : 'gestionnaire.meal-distributions';
@endphp

<div class="page-header">

    <div>
        <h1>Edit Meal Presence</h1>

        <p style="margin:0; color:var(--text-secondary);">
            Update the meal distribution record.
        </p>
    </div>

    <a
        href="{{ route($distributionRoute . '.show', $mealDistribution) }}"
        class="btn btn-secondary"
    >
        ← Back
    </a>

</div>

@if($errors->any())

    <div class="alert-danger" style="margin-bottom:20px;">

        <strong>Please correct the following:</strong>

        <ul style="margin:10px 0 0 20px;">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<div class="card">

    {{-- Reservation information --}}

    <div
        style="
            margin-bottom:25px;
            padding:18px;
            background:#F8FAFC;
            border-radius:10px;
        "
    >

        <h3 style="margin-top:0;">
            Reservation Information
        </h3>

        <p style="margin-bottom:8px;">
            <strong>Student:</strong>
            {{ $mealDistribution->reservation->student->first_name }}
            {{ $mealDistribution->reservation->student->last_name }}
        </p>

        <p style="margin-bottom:8px;">
            <strong>Student Code:</strong>
            {{ $mealDistribution->reservation->student->student_code }}
        </p>

        <p style="margin-bottom:8px;">
            <strong>Class:</strong>
            {{ $mealDistribution->reservation->student->schoolClass->name ?? '—' }}
        </p>

        <p style="margin-bottom:8px;">
            <strong>Menu Date:</strong>
            {{ $mealDistribution->reservation->menu->service_date->format('d/m/Y') }}
        </p>

        <p style="margin-bottom:0;">
            <strong>Meal:</strong>
            {{ $mealDistribution->reservation->menu->dishes->pluck('name')->join(', ') }}
        </p>

    </div>

    <form
        method="POST"
        action="{{ route($distributionRoute . '.update', $mealDistribution) }}"
    >

        @csrf

        @method('PUT')

        <div class="form-grid">

            {{-- Status --}}

            <div class="form-group">

                <label for="status">

                    Status
                    <span style="color:#DC2626;">*</span>

                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option
                        value="served"
                        @selected(old('status', $mealDistribution->status) === 'served')
                    >
                        Served
                    </option>

                    <option
                        value="not_served"
                        @selected(old('status', $mealDistribution->status) === 'not_served')
                    >
                        Not Served
                    </option>

                </select>

            </div>

        </div>

        {{-- Notes --}}

        <div class="form-group" style="margin-top:20px;">

            <label for="notes">
                Notes
            </label>

            <textarea
                id="notes"
                name="notes"
                rows="4"
                placeholder="Optional notes..."
            >{{ old('notes', $mealDistribution->notes) }}</textarea>

        </div>

        <div class="form-actions" style="margin-top:20px;">

            <button
                type="submit"
                class="btn btn-success"
            >
                ✓ Update Presence
            </button>

            <a
                href="{{ route($distributionRoute . '.show', $mealDistribution) }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection