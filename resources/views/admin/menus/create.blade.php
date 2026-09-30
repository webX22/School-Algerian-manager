@extends('layouts.admin')

@section('title', 'Schedule Menu')

@section('content')

@php
    $menuRoute = auth()->user()->role === 'admin'
        ? 'admin.menus'
        : 'gestionnaire.menus';
@endphp

<div class="page-header">

    <div>
        <h1>Schedule Daily Menu</h1>
        <p>Create a menu and assign one or more dishes to it.</p>
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

        <strong>
            Please correct the following errors:
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
        action="{{ route($menuRoute . '.store') }}"
    >

        @csrf

        <div class="form-grid">

            <div class="form-group">

                <label for="dish_ids">
                    Dishes
                    <span style="color:#DC2626;">*</span>
                </label>

                <select
                    id="dish_ids"
                    name="dish_ids[]"
                    multiple
                    required
                    style="min-height:140px;"
                >

                    @foreach($dishes as $dish)

                        <option
                            value="{{ $dish->id }}"
                            @selected(
                                in_array(
                                    $dish->id,
                                    old('dish_ids', [])
                                )
                            )
                        >
                            {{ $dish->name }}
                        </option>

                    @endforeach

                </select>

                <small style="color:#64748B;">
                    Hold Ctrl and select multiple dishes.
                </small>

            </div>

            <div class="form-group">

                <label for="service_date">
                    Service Date
                    <span style="color:#DC2626;">*</span>
                </label>

                <input
                    type="date"
                    id="service_date"
                    name="service_date"
                    value="{{ old('service_date') }}"
                    required
                >

            </div>

            <div class="form-group">

                <label for="service_time">
                    Service Time (24-hour)
                </label>

                <input
                    type="text"
                    id="service_time"
                    name="service_time"
                    value="{{ old('service_time') }}"
                    placeholder="HH:MM"
                    pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$"
                    maxlength="5"
                    inputmode="numeric"
                >

                <small style="color:#64748B;">
                    Military time — example: 07:30, 12:00, 13:45, 18:30
                </small>

            </div>

            <div class="form-group">

                <label for="planned_quantity">
                    Planned Quantity
                    <span style="color:#DC2626;">*</span>
                </label>

                <input
                    type="number"
                    id="planned_quantity"
                    name="planned_quantity"
                    value="{{ old('planned_quantity', 0) }}"
                    min="0"
                    required
                >

                <small style="color:#64748B;">
                    Expected number of students to be served.
                </small>

            </div>

        </div>

        <div class="form-group">

            <label for="notes">
                Notes
            </label>

            <textarea
                id="notes"
                name="notes"
                rows="4"
                placeholder="Optional notes about this daily menu..."
            >{{ old('notes') }}</textarea>

        </div>

        <div class="form-group">

            <label
                style="display:flex; align-items:center; gap:10px; cursor:pointer;"
            >

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', true))
                    style="width:auto;"
                >

                <span>
                    Active menu
                </span>

            </label>

        </div>

        <div
            class="form-actions"
            style="margin-top:25px;"
        >

            <button
                type="submit"
                class="btn btn-primary"
            >
                ✓ Schedule Menu
            </button>

            <a
                href="{{ route($menuRoute . '.index') }}"
                class="btn"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection