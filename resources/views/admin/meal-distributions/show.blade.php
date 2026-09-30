@extends('layouts.admin')

@section('title', 'Meal Presence Details')

@section('content')

@php
    $distributionRoute = auth()->user()->role === 'admin'
        ? 'admin.meal-distributions'
        : 'gestionnaire.meal-distributions';
@endphp

<div class="page-header">

    <div>
        <h1>Meal Presence Details</h1>

        <p style="margin:0; color:var(--text-secondary);">
            View meal distribution information.
        </p>
    </div>

</div>

@if(session('success'))

    <div class="alert-success" style="margin-bottom:20px;">
        {{ session('success') }}
    </div>

@endif

<div class="card">

    <div style="display:grid; gap:18px;">

        {{-- Student --}}

        <div>
            <strong>Student</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->reservation->student->first_name }}
                {{ $mealDistribution->reservation->student->last_name }}
            </div>
        </div>

        {{-- Student Code --}}

        <div>
            <strong>Student Code</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->reservation->student->student_code }}
            </div>
        </div>

        {{-- Class --}}

        <div>
            <strong>Class</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->reservation->student->schoolClass->name ?? '—' }}
            </div>
        </div>

        {{-- Menu Date --}}

        <div>
            <strong>Menu Date</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->reservation->menu->service_date->format('d/m/Y') }}
            </div>
        </div>

        {{-- Meal --}}

        <div>
            <strong>Meal</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->reservation->menu->dishes->pluck('name')->join(', ') }}
            </div>
        </div>

        {{-- Status --}}

        <div>
            <strong>Status</strong>

            <div style="margin-top:5px;">

                @if($mealDistribution->status === 'served')

                    <span
                        style="
                            display:inline-block;
                            padding:6px 12px;
                            border-radius:20px;
                            background:#DCFCE7;
                            color:#166534;
                            font-weight:600;
                        "
                    >
                        Served
                    </span>

                @else

                    <span
                        style="
                            display:inline-block;
                            padding:6px 12px;
                            border-radius:20px;
                            background:#FEE2E2;
                            color:#991B1B;
                            font-weight:600;
                        "
                    >
                        Not Served
                    </span>

                @endif

            </div>
        </div>

        {{-- Served At --}}

        <div>
            <strong>Served At</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->served_at
                    ? $mealDistribution->served_at->format('d/m/Y H:i')
                    : '—'
                }}
            </div>
        </div>

        {{-- Served By --}}

        <div>
            <strong>Recorded By</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->servedBy->name ?? '—' }}
            </div>
        </div>

        {{-- Notes --}}

        <div>
            <strong>Notes</strong>

            <div style="margin-top:5px;">
                {{ $mealDistribution->notes ?: '—' }}
            </div>
        </div>

    </div>

    <div class="form-actions" style="margin-top:25px;">

        <a
            href="{{ route($distributionRoute . '.edit', $mealDistribution) }}"
            class="btn btn-secondary"
        >
            Edit
        </a>

        <a
            href="{{ route($distributionRoute . '.index') }}"
            class="btn"
            style="background:#E2E8F0; color:var(--text);"
        >
            Back
        </a>

        <form
            method="POST"
            action="{{ route($distributionRoute . '.destroy', $mealDistribution) }}"
            style="display:inline;"
            onsubmit="return confirm('Are you sure you want to delete this meal presence record?');"
        >

            @csrf

            @method('DELETE')

            <button
                type="submit"
                class="btn"
                style="background:#DC2626; color:white;"
            >
                Delete
            </button>

        </form>

    </div>

</div>

@endsection