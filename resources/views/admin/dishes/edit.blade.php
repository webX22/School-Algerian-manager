@extends('layouts.admin')

@section('title', 'Edit Dish')

@section('content')

@php
    $dishRoute = auth()->user()->role === 'admin'
        ? 'admin.dishes'
        : 'gestionnaire.dishes';
@endphp

<div class="page-header">

    <div>
        <h1>Edit Dish</h1>
        <p>Update the information for this dish.</p>
    </div>

    <a
        href="{{ route($dishRoute . '.index') }}"
        class="btn btn-secondary"
    >
        Back to Dishes
    </a>

</div>

<div class="card">

    <form
        method="POST"
        action="{{ route($dishRoute . '.update', $dish) }}"
    >

        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">

                <label for="name">
                    Dish Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $dish->name) }}"
                    required
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
                        @selected(old('dish_type', $dish->dish_type) === 'appetizer')
                    >
                        Appetizer
                    </option>

                    <option
                        value="main_course"
                        @selected(old('dish_type', $dish->dish_type) === 'main_course')
                    >
                        Main Course
                    </option>

                    <option
                        value="dessert"
                        @selected(old('dish_type', $dish->dish_type) === 'dessert')
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
            >{{ old('description', $dish->description) }}</textarea>

            @error('description')
                <small style="color: var(--danger);">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="form-group">

            <label style="display: flex; align-items: center; gap: 8px;">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', $dish->is_active))
                >

                Active

            </label>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Dish
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