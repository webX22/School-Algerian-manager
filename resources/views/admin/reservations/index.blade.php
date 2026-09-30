@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')

@php
    $reservationRoute = auth()->user()->role === 'admin'
        ? 'admin.reservations'
        : 'gestionnaire.reservations';
@endphp

<div class="page-header">

    <div>
        <h1>Reservations</h1>
        <p>Manage student meal reservations.</p>
    </div>

    <a
        href="{{ route($reservationRoute . '.create') }}"
        class="btn btn-primary"
    >
        + New Reservation
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

@if($errors->any())

    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>

@endif

<div class="card">

    <form
        method="GET"
        action="{{ route($reservationRoute . '.index') }}"
        class="filter-form"
    >

        <div class="form-group">

            <label for="student_id">
                Student
            </label>

            <select
                id="student_id"
                name="student_id"
            >

                <option value="">
                    All Students
                </option>

                @foreach($students as $student)

                    <option
                        value="{{ $student->id }}"
                        @selected(request('student_id') == $student->id)
                    >
                        {{ $student->first_name }}
                        {{ $student->last_name }}
                        — {{ $student->student_code }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label for="menu_id">
                Menu
            </label>

            <select
                id="menu_id"
                name="menu_id"
            >

                <option value="">
                    All Menus
                </option>

                @foreach($menus as $menu)

                    <option
                        value="{{ $menu->id }}"
                        @selected(request('menu_id') == $menu->id)
                    >
                        {{ $menu->service_date->format('d/m/Y') }}
                        —
                        {{ $menu->dishes->pluck('name')->join(', ') }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
            >

                <option value="">
                    All Statuses
                </option>

                <option
                    value="reserved"
                    @selected(request('status') === 'reserved')
                >
                    Reserved
                </option>

                <option
                    value="cancelled"
                    @selected(request('status') === 'cancelled')
                >
                    Cancelled
                </option>

            </select>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-secondary"
            >
                Filter
            </button>

            <a
                href="{{ route($reservationRoute . '.index') }}"
                class="btn"
            >
                Reset
            </a>

        </div>

    </form>

</div>

<div class="card">

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>
                    <th>Date</th>
                    <th>Meal</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Reserved At</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse($reservations as $reservation)

                    <tr>

                        <td>
                            {{ $reservation->menu->service_date->format('d/m/Y') }}
                        </td>

                        <td>
                            <strong>
                                {{ $reservation->menu->dishes->pluck('name')->join(', ') }}
                            </strong>
                        </td>

                        <td>

                            {{ $reservation->student->first_name }}
                            {{ $reservation->student->last_name }}

                            <br>

                            <small style="color:#64748B;">
                                {{ $reservation->student->student_code }}
                            </small>

                        </td>

                        <td>
                            {{ $reservation->student->schoolClass->name ?? '—' }}
                        </td>

                        <td>

                            @if($reservation->status === 'reserved')

                                <span class="badge badge-success">
                                    Reserved
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Cancelled
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $reservation->reserved_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route($reservationRoute . '.show', $reservation) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route($reservationRoute . '.edit', $reservation) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route($reservationRoute . '.destroy', $reservation) }}"
                                    style="display:inline"
                                    onsubmit="return confirm('Are you sure you want to delete this reservation?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="text-align:center; padding:30px;"
                        >
                            No reservations found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection