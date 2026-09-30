@extends('layouts.admin')

@section('title', 'Edit Reservation')

@section('content')

@php
    $reservationRoute = auth()->user()->role === 'admin'
        ? 'admin.reservations'
        : 'gestionnaire.reservations';
@endphp

<div class="page-header">

    <div>
        <h1>Edit Reservation</h1>
        <p>Update the student meal reservation.</p>
    </div>

    <a
        href="{{ route($reservationRoute . '.index') }}"
        class="btn btn-secondary"
    >
        ← Back
    </a>

</div>

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Please correct the following:
        </strong>

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
        action="{{ route($reservationRoute . '.update', $reservation) }}"
    >

        @csrf
        @method('PUT')

        <div class="form-grid">

            {{-- Student --}}

            <div class="form-group">

                <label for="student_id">
                    Student
                    <span style="color:#DC2626;">*</span>
                </label>

                <select
                    id="student_id"
                    name="student_id"
                    required
                >

                    <option value="">
                        Select Student
                    </option>

                    @foreach($students as $student)

                        <option
                            value="{{ $student->id }}"
                            @selected(old('student_id', $reservation->student_id) == $student->id)
                        >
                            {{ $student->first_name }}
                            {{ $student->last_name }}
                            —
                            {{ $student->student_code }}
                            —
                            {{ $student->schoolClass->name ?? 'No Class' }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Menu --}}

            <div class="form-group">

                <label for="menu_id">
                    Menu
                    <span style="color:#DC2626;">*</span>
                </label>

                <select
                    id="menu_id"
                    name="menu_id"
                    required
                >

                    <option value="">
                        Select Menu
                    </option>

                    @foreach($menus as $menu)

                        <option
                            value="{{ $menu->id }}"
                            @selected(old('menu_id', $reservation->menu_id) == $menu->id)
                        >

                            {{ $menu->service_date->format('d/m/Y') }}

                            —

                            {{ $menu->dishes->pluck('name')->join(', ') }}

                            @if($menu->service_time)

                                —
                                {{ \Carbon\Carbon::parse($menu->service_time)->format('H:i') }}

                            @endif

                        </option>

                    @endforeach

                </select>

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

                    <option
                        value="reserved"
                        @selected(old('status', $reservation->status) === 'reserved')
                    >
                        Reserved
                    </option>

                    <option
                        value="cancelled"
                        @selected(old('status', $reservation->status) === 'cancelled')
                    >
                        Cancelled
                    </option>

                </select>

            </div>

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
                Reservation information
            </strong>

            <br>

            Reservation ID:
            #{{ $reservation->id }}

            <br>

            Reserved at:
            {{ $reservation->reserved_at?->format('d/m/Y H:i') ?? '—' }}

        </div>

        <div
            class="form-actions"
            style="margin-top:20px;"
        >

            <button
                type="submit"
                class="btn btn-success"
            >
                ✓ Update Reservation
            </button>

            <a
                href="{{ route($reservationRoute . '.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection