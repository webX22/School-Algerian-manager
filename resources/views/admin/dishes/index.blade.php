@extends('layouts.admin')

@section('title', 'Dishes Management')

@section('content')

@php
    $dishRoute = auth()->user()->role === 'admin'
        ? 'admin.dishes'
        : 'gestionnaire.dishes';
@endphp

<div class="page-header">

    <div>
        <h1>Dishes Management</h1>
        <p>Manage dishes available in the school restaurant.</p>
    </div>

    <a href="{{ route($dishRoute . '.create') }}" class="btn btn-primary">
        + Add Dish
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

<div class="card">

    <form method="GET" action="{{ route($dishRoute . '.index') }}" class="filter-form">

        <div class="form-group">

            <label for="search">Search</label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search dish name..."
            >

        </div>

        <div class="form-group">

            <label for="dish_type">Dish Type</label>

            <select id="dish_type" name="dish_type">

                <option value="">All Types</option>

                <option
                    value="appetizer"
                    @selected(request('dish_type') === 'appetizer')
                >
                    Appetizer
                </option>

                <option
                    value="main_course"
                    @selected(request('dish_type') === 'main_course')
                >
                    Main Course
                </option>

                <option
                    value="dessert"
                    @selected(request('dish_type') === 'dessert')
                >
                    Dessert
                </option>

            </select>

        </div>

        <div class="form-group">

            <label for="status">Status</label>

            <select id="status" name="status">

                <option value="">All Statuses</option>

                <option
                    value="active"
                    @selected(request('status') === 'active')
                >
                    Active
                </option>

                <option
                    value="inactive"
                    @selected(request('status') === 'inactive')
                >
                    Inactive
                </option>

            </select>

        </div>

        <div class="filter-actions">

            <button type="submit" class="btn btn-primary">
                Search
            </button>

            <a
                href="{{ route($dishRoute . '.index') }}"
                class="btn btn-secondary"
            >
                Reset
            </a>

        </div>

    </form>

</div>

<div class="card">

    <div class="card-header">

        <div>

            <h2>Dishes</h2>

            <span>
                {{ $dishes->count() }} dish(s)
            </span>

        </div>

    </div>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th>Dish</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse($dishes as $dish)

                    <tr>

                        <td>
                            <strong>
                                {{ $dish->name }}
                            </strong>
                        </td>

                        <td>

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

                        </td>

                        <td>
                            {{ $dish->description
                                ? Str::limit($dish->description, 50)
                                : '—' }}
                        </td>

                        <td>

                            @if($dish->is_active)

                                <span class="badge badge-success">
                                    Active
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route($dishRoute . '.show', $dish) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route($dishRoute . '.edit', $dish) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route($dishRoute . '.destroy', $dish) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this dish?');"
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
                            colspan="5"
                            style="text-align:center; padding:40px;"
                        >
                            No dishes found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection