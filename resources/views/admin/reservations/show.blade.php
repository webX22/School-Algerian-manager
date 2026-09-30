@extends('layouts.admin')

@section('title', 'Reservation Details')

@section('content')

@php
    $reservationRoute = auth()->user()->role === 'admin'
        ? 'admin.reservations'
        : 'gestionnaire.reservations';
@endphp

<div class="page-header">

    <div>
        <h1>Reservation Details</h1>
        <p>View reservation information.</p>
    </div>

    <a
        href="{{ route($reservationRoute . '.index') }}"
        class="btn btn-secondary"
    >
        ← Back
    </a>

</div>

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif

@if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>

@endif

<div class="card">

    <div style="display:grid; gap:20px;">

        <div>
            <strong>Student</strong>

            <div style="margin-top:6px; color:#64748B;">
                {{ $reservation->student->first_name }}
                {{ $reservation->student->last_name }}
            </div>
        </div>

        <div>
            <strong>Student Code</strong>

            <div style="margin-top:6px; color:#64748B;">
                {{ $reservation->student->student_code }}
            </div>
        </div>

        <div>
            <strong>Class</strong>

            <div style="margin-top:6px; color:#64748B;">
                {{ $reservation->student->schoolClass->name ?? 'No Class' }}
            </div>
        </div>

        <div>
            <strong>Menu Date</strong>

            <div style="margin-top:6px; color:#64748B;">
                {{ $reservation->menu->service_date->format('d/m/Y') }}
            </div>
        </div>

        <div>
            <strong>Meal</strong>

            <div style="margin-top:6px; color:#64748B;">
                {{ $reservation->menu->dishes->pluck('name')->join(', ') }}
            </div>
        </div>

        <div>
            <strong>Service Time</strong>

            <div style="margin-top:6px; color:#64748B;">
                @if($reservation->menu->service_time)
                    {{ \Carbon\Carbon::parse($reservation->menu->service_time)->format('H:i') }}
                @else
                    —
                @endif
            </div>
        </div>

        <div>
            <strong>Status</strong>

            <div style="margin-top:8px;">

                @if($reservation->status === 'reserved')

                    <span class="badge badge-success">
                        Reserved
                    </span>

                @else

                    <span class="badge badge-danger">
                        Cancelled
                    </span>

                @endif

            </div>
        </div>

        <div>
            <strong>Reserved At</strong>

            <div style="margin-top:6px; color:#64748B;">
                {{ $reservation->reserved_at?->format('d/m/Y H:i') ?? '—' }}
            </div>
        </div>

        @if($reservation->cancelled_at)

            <div>
                <strong>Cancelled At</strong>

                <div style="margin-top:6px; color:#64748B;">
                    {{ $reservation->cancelled_at->format('d/m/Y H:i') }}
                </div>
            </div>

        @endif

    </div>

    <div
        class="form-actions"
        style="margin-top:25px;"
    >

        <a
            href="{{ route($reservationRoute . '.edit', $reservation) }}"
            class="btn btn-primary"
        >
            Edit Reservation
        </a>

        <a
            href="{{ route($reservationRoute . '.index') }}"
            class="btn btn-secondary"
        >
            Back to Reservations
        </a>

    </div>

</div>

@endsection