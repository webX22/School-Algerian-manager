@extends('layouts.admin')

@section('title', 'Edit Daily Menu')

@section('content')

@php
$menuRoute = auth()->user()->role === 'admin'
? 'admin.menus'
: 'gestionnaire.menus';
@endphp

<div style=" display:flex; align-items:center; justify-content:space-between; gap:20px; margin-bottom:25px; flex-wrap:wrap; " > <div> <h1>Edit Daily Menu</h1>

    <p style="color:var(--text-secondary); margin:0;">
        Update the menu, dishes, date and service information.
    </p>
</div>

<a
    href="{{ route($menuRoute . '.index') }}"
    class="btn btn-secondary"
>
    ← Back to Menus
</a>

</div>

@if($errors->any())

<div class="alert alert-danger">

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
    action="{{ route($menuRoute . '.update', $menu) }}"
>

    @csrf

    @method('PUT')


    {{-- Service Date --}}

    <div style="margin-bottom:20px;">

        <label
            for="service_date"
            style="
                display:block;
                margin-bottom:7px;
                font-weight:700;
            "
        >
            Service Date
            <span style="color:#DC2626;">*</span>
        </label>

        <input
            type="date"
            id="service_date"
            name="service_date"
            value="{{ old('service_date', $menu->service_date?->format('Y-m-d')) }}"
            required
        >

    </div>


    {{-- Service Time --}}

    <div style="margin-bottom:20px;">

        <label
            for="service_time"
            style="
                display:block;
                margin-bottom:7px;
                font-weight:700;
            "
        >
            Service Time
        </label>

        <input
            type="time"
            id="service_time"
            name="service_time"
            value="{{ old('service_time', $menu->service_time) }}"
        >

    </div>


    {{-- Planned Quantity --}}

    <div style="margin-bottom:20px;">

        <label
            for="planned_quantity"
            style="
                display:block;
                margin-bottom:7px;
                font-weight:700;
            "
        >
            Planned Quantity
        </label>

        <input
            type="number"
            id="planned_quantity"
            name="planned_quantity"
            min="0"
            value="{{ old('planned_quantity', $menu->planned_quantity) }}"
        >

    </div>


    {{-- Dishes --}}

    <div style="margin-bottom:20px;">

        <label
            style="
                display:block;
                margin-bottom:10px;
                font-weight:700;
            "
        >
            Dishes
            <span style="color:#DC2626;">*</span>
        </label>

        @if($dishes->count())

            <div
                style="
                    display:grid;
                    grid-template-columns:
                        repeat(
                            auto-fit,
                            minmax(220px, 1fr)
                        );
                    gap:10px;
                "
            >

                @php
                    $selectedDishes = old(
                        'dish_ids',
                        $menu->dishes->pluck('id')->toArray()
                    );
                @endphp

                @foreach($dishes as $dish)

                    <label
                        style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            padding:12px;
                            border:1px solid #E2E8F0;
                            border-radius:10px;
                            cursor:pointer;
                        "
                    >

                        <input
                            type="checkbox"
                            name="dish_ids[]"
                            value="{{ $dish->id }}"
                            @checked(
                                in_array(
                                    $dish->id,
                                    $selectedDishes
                                )
                            )
                        >

                        <span>
                            {{ $dish->name }}
                        </span>

                    </label>

                @endforeach

            </div>

        @else

            <p style="color:var(--text-secondary);">
                No active dishes available.
            </p>

        @endif

    </div>


    {{-- Notes --}}

    <div style="margin-bottom:20px;">

        <label
            for="notes"
            style="
                display:block;
                margin-bottom:7px;
                font-weight:700;
            "
        >
            Notes
        </label>

        <textarea
            id="notes"
            name="notes"
            rows="4"
            placeholder="Optional notes..."
        >{{ old('notes', $menu->notes) }}</textarea>

    </div>


    {{-- Active Menu --}}

    <div style="margin-bottom:25px;">

        <label
            style="
                display:flex;
                align-items:center;
                gap:10px;
                cursor:pointer;
            "
        >

            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $menu->is_active))
            >

            <span style="font-weight:700;">
                Active Menu
            </span>

        </label>

    </div>


    {{-- Actions --}}

    <div class="form-actions">

        <button
            type="submit"
            class="btn btn-primary"
        >
            ✓ Update Menu
        </button>

        <a
            href="{{ route($menuRoute . '.index') }}"
            class="btn btn-secondary"
        >
            Cancel
        </a>

    </div>

</form>

</div>

<style> @media (max-width: 700px) { .card > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; } } </style>

@endsection