@extends('layouts.admin')

@section('title', 'Meal Details')

@section('content')

<div class="page-header">
    <div>
        <h1>Meal Details</h1>
        <p>View complete information about this meal.</p>
    </div>

    <div class="action-buttons">

        <a
            href="{{ route('meals.edit', $meal) }}"
            class="btn btn-primary"
        >
            Edit Meal
        </a>

        <a
            href="{{ route('meals.index') }}"
            class="btn btn-secondary"
        >
            ← Back to Meals
        </a>

    </div>
</div>

<div class="card">

    <div class="card-header">

        <div>
            <h2>{{ $meal->name }}</h2>

            <span>
                {{ ucfirst($meal->meal_type) }}
            </span>
        </div>

        @if($meal->is_active)

            <span class="badge badge-success">
                Active
            </span>

        @else

            <span class="badge badge-danger">
                Inactive
            </span>

        @endif

    </div>

    <div class="form-grid">

        <div class="form-group">
            <label>Meal Name</label>

            <div class="detail-value">
                {{ $meal->name }}
            </div>
        </div>

        <div class="form-group">
            <label>Meal Type</label>

            <div class="detail-value">
                {{ ucfirst($meal->meal_type) }}
            </div>
        </div>

        <div class="form-group">
            <label>Estimated Cost</label>

            <div class="detail-value">
                {{ number_format((float) $meal->cost, 2) }} DA
            </div>
        </div>

        <div class="form-group">
            <label>Status</label>

            <div class="detail-value">
                @if($meal->is_active)
                    Active
                @else
                    Inactive
                @endif
            </div>
        </div>

        <div class="form-group" style="grid-column: 1 / -1;">
            <label>Description</label>

            <div class="detail-value">
                {{ $meal->description ?? 'No description provided.' }}
            </div>
        </div>

    </div>

</div>

@endsection