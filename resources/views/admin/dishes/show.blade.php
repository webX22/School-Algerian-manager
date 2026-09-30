@extends('layouts.admin')

@section('title', 'Dish Details')

@section('content')

@php
    $dishRoute = auth()->user()->role === 'admin'
        ? 'admin.dishes'
        : 'gestionnaire.dishes';
@endphp

<div class="page-header">

    <div>
        <h1>Dish Details</h1>
        <p>View information about this dish.</p>
    </div>

    <div class="form-actions">

        <a
            href="{{ route($dishRoute . '.edit', $dish) }}"
            class="btn btn-primary"
        >
            Edit Dish
        </a>

        <a
            href="{{ route($dishRoute . '.index') }}"
            class="btn btn-secondary"
        >
            Back to Dishes
        </a>

    </div>

</div>

<div class="card">

    <div class="card-header">

        <div>
            <h2>{{ $dish->name }}</h2>
            <span>Dish information</span>
        </div>

    </div>

    <div class="form-grid">

        <div class="form-group">

            <label>Dish Name</label>

            <div>
                {{ $dish->name }}
            </div>

        </div>

        <div class="form-group">

            <label>Dish Type</label>

            <div>

                @switch($dish->dish_type)

                    @case('appetizer')
                        Appetizer
                        @break

                    @case('main_course')
                        Main Course
                        @break

                    @case('dessert')
                        Dessert
                        @break

                    @default
                        —
                @endswitch

            </div>

        </div>

        <div class="form-group">

            <label>Status</label>

            <div>

                @if($dish->is_active)

                    <span class="badge badge-success">
                        Active
                    </span>

                @else

                    <span class="badge badge-danger">
                        Inactive
                    </span>

                @endif

            </div>

        </div>

        <div class="form-group">

            <label>Description</label>

            <div>
                {{ $dish->description ?: '—' }}
            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">

        <div>
            <h2>Daily Menus</h2>
            <span>Menus using this dish</span>
        </div>

    </div>

    @forelse($dish->menus as $menu)

        <div style="padding: 12px 0; border-bottom: 1px solid #E2E8F0;">

            <strong>
                {{ $menu->service_date->format('d/m/Y') }}
            </strong>

            @if($menu->service_time)

                <span style="margin-left: 15px;">
                    {{ \Carbon\Carbon::parse($menu->service_time)->format('H:i') }}
                </span>

            @endif

        </div>

    @empty

        <p style="color: var(--text-secondary);">
            This dish is not assigned to any daily menu.
        </p>

    @endforelse

</div>

@endsection