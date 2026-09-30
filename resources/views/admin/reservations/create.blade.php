@extends('layouts.admin')

@section('title', 'New Reservation')

@section('content')

@php
    $reservationRoute = auth()->user()->role === 'admin'
        ? 'admin.reservations'
        : 'gestionnaire.reservations';
@endphp

<div class="page-header">

    <div>
        <h1>New Reservation</h1>
        <p>Reserve a meal for a student.</p>
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

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif

<div class="card">

    <form
        method="POST"
        action="{{ route($reservationRoute . '.store') }}"
    >

        @csrf

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
                            @selected(old('student_id') == $student->id)
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

                <small style="color:#64748B;">
                    Select the student making the reservation.
                </small>

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
                            @selected(old('menu_id') == $menu->id)
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

                <small style="color:#64748B;">
                    Only active future menus are available for reservation.
                </small>

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
                Reservation rule
            </strong>

            <br>

            A student can reserve a specific menu only once.
            Duplicate active reservations are not allowed.

        </div>

        <div
            class="form-actions"
            style="margin-top:20px;"
        >

            <button
                type="submit"
                class="btn btn-success"
            >
                ✓ Create Reservation
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