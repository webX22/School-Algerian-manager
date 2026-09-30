@extends('layouts.admin')

@section('title', 'Record Meal Presence')

@section('content')

@php
    $distributionRoute = auth()->user()->role === 'admin'
        ? 'admin.meal-distributions'
        : 'gestionnaire.meal-distributions';
@endphp

<div class="page-header">

    <div>
        <h1>Record Meal Presence</h1>

        <p style="margin:0; color:var(--text-secondary);">
            Record whether a reserved meal was served to a student.
        </p>
    </div>

    <a
        href="{{ route($distributionRoute . '.index') }}"
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

    <form
        method="POST"
        action="{{ route($distributionRoute . '.store') }}"
    >

        @csrf

        <div class="form-grid">

            {{-- Reservation --}}

            <div class="form-group">

                <label for="reservation_id">

                    Reservation
                    <span style="color:#DC2626;">*</span>

                </label>

                <select
                    id="reservation_id"
                    name="reservation_id"
                    required
                >

                    <option value="">
                        Select Reservation
                    </option>

                    @foreach($reservations as $reservation)

                        <option
                            value="{{ $reservation->id }}"
                            @selected(old('reservation_id') == $reservation->id)
                        >

                            {{ $reservation->student->first_name }}
                            {{ $reservation->student->last_name }}

                            —

                            {{ $reservation->student->student_code }}

                            —

                            {{ $reservation->menu->service_date->format('d/m/Y') }}

                            —

                            {{ $reservation->menu->dishes->pluck('name')->join(', ') }}

                        </option>

                    @endforeach

                </select>

                <small style="color:#64748B;">
                    Only active reservations are available.
                </small>

            </div>

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

                    <option value="">
                        Select Status
                    </option>

                    <option
                        value="served"
                        @selected(old('status') === 'served')
                    >
                        Served
                    </option>

                    <option
                        value="not_served"
                        @selected(old('status') === 'not_served')
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
            >{{ old('notes') }}</textarea>

        </div>

        <div
            style="
                margin-top:20px;
                padding:15px;
                background:#F8FAFC;
                border-radius:8px;
                color:#64748B;
            "
        >

            <strong style="color:#172033;">
                Distribution rule
            </strong>

            <br>

            Each reservation can have only one meal presence record.

        </div>

        <div
            class="form-actions"
            style="margin-top:20px;"
        >

            <button
                type="submit"
                class="btn btn-success"
            >
                ✓ Record Presence
            </button>

            <a
                href="{{ route($distributionRoute . '.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection