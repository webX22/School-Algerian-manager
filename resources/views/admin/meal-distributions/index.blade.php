@extends('layouts.admin')

@section('title', 'Meal Distribution')

@section('content')

@php
    $distributionRoute = auth()->user()->role === 'admin'
        ? 'admin.meal-distributions'
        : 'gestionnaire.meal-distributions';
@endphp

<div class="page-header">

    <div>
        <h1>Meal Distribution</h1>

        <p style="margin:0; color:var(--text-secondary);">
            Track students receiving meals from their reservations.
        </p>
    </div>

    <a
        href="{{ route($distributionRoute . '.create') }}"
        class="btn btn-primary"
    >
        + Record Presence
    </a>

</div>

@if(session('success'))

    <div class="alert-success" style="margin-bottom:20px;">
        {{ session('success') }}
    </div>

@endif

@if(session('error'))

    <div class="alert-danger" style="margin-bottom:20px;">
        {{ session('error') }}
    </div>

@endif

@if($errors->any())

    <div class="alert-danger" style="margin-bottom:20px;">

        {{ $errors->first() }}

    </div>

@endif

<div class="card">

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>
                    <th>Student</th>
                    <th>Menu Date</th>
                    <th>Meal</th>
                    <th>Status</th>
                    <th>Served At</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse($mealDistributions as $distribution)

                    <tr>

                        <td>

                            @if($distribution->student)

                                <strong>
                                    {{ $distribution->student->first_name }}
                                    {{ $distribution->student->last_name }}
                                </strong>

                                <br>

                                <small style="color:#64748B;">
                                    {{ $distribution->student->student_code }}
                                </small>

                            @else

                                —

                            @endif

                        </td>

                        <td>

                            @if($distribution->menu)

                                {{ $distribution->menu->service_date->format('d/m/Y') }}

                            @else

                                —

                            @endif

                        </td>

                        <td>

                            @if($distribution->menu)

                                {{ $distribution->menu->dishes->pluck('name')->join(', ') }}

                            @else

                                —

                            @endif

                        </td>

                        <td>

                            @if($distribution->status === 'served')

                                <span class="badge badge-success">
                                    Served
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Not Served
                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $distribution->served_at?->format('d/m/Y H:i') ?? '—' }}

                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route($distributionRoute . '.show', $distribution) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route($distributionRoute . '.edit', $distribution) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route($distributionRoute . '.destroy', $distribution) }}"
                                    style="display:inline"
                                    onsubmit="return confirm('Are you sure you want to delete this meal distribution record?');"
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
                            colspan="6"
                            style="text-align:center; padding:30px;"
                        >
                            No meal distribution records found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection