@extends('layouts.admin')

@section('title', 'Add Dish')

@section('content')

@php
    $dishRoute = auth()->user()->role === 'admin'
        ? 'admin.dishes'
        : 'gestionnaire.dishes';
@endphp

<div class="page-header">

    <div>
        <h1>Add Dish</h1>
        <p>Create a new dish for the school restaurant.</p>
    </div>

    <a
        href="{{ route($dishRoute . '.index') }}"
        class="btn btn-secondary"
    >
        Back to Dishes
    </a>

</div>

<div class="card">

    <form method="POST" action="{{ route($dishRoute . '.store') }}">

        @csrf

        <div class="form-grid">

            <div class="form-group">

                <label for="name">
                    Dish Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="e.g. Couscous"
                >

                @error('name')
                    <small style="color: var(--danger);">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <div class="form-group">

                <label for="dish_type">
                    Dish Type
                </label>

                <select
                    id="dish_type"
                    name="dish_type"
                    required
                >

                    <option value="">
                        Select type
                    </option>

                    <option
                        value="appetizer"
                        @selected(old('dish_type') === 'appetizer')
                    >
                        Appetizer
                    </option>

                    <option
                        value="main_course"
                        @selected(old('dish_type') === 'main_course')
                    >
                        Main Course
                    </option>

                    <option
                        value="dessert"
                        @selected(old('dish_type') === 'dessert')
                    >
                        Dessert
                    </option>

                </select>

                @error('dish_type')
                    <small style="color: var(--danger);">
                        {{ $message }}
                    </small>
                @enderror

            </div>

        </div>

        <div class="form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Optional description..."
            >{{ old('description') }}</textarea>

            @error('description')
                <small style="color: var(--danger);">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="form-group">

            <label style="display:flex; align-items:center; gap:8px;">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', true))
                >

                Active

            </label>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Dish
            </button>

            <a
                href="{{ route($dishRoute . '.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection