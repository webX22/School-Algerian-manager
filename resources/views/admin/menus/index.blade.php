@extends('layouts.admin')

@section('title', 'Daily Menus')

@section('content')

@php
    $menuRoute = auth()->user()->role === 'admin'
        ? 'admin.menus'
        : 'gestionnaire.menus';
@endphp

<div
    style="
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
        margin-bottom:25px;
        flex-wrap:wrap;
    "
>

    <div>
        <h1>Daily Menus</h1>

        <p style="color:var(--text-secondary); margin:0;">
            Manage daily school meal menus.
        </p>
    </div>

    <a
        href="{{ route($menuRoute . '.create') }}"
        class="btn btn-primary"
    >
        + Create Menu
    </a>

</div>


{{-- Filters --}}

<div class="card" style="margin-bottom:20px;">

    <form
        method="GET"
        action="{{ route($menuRoute . '.index') }}"
    >

        <div
            style="
                display:grid;
                grid-template-columns:
                    minmax(200px, 1.5fr)
                    minmax(160px, 1fr)
                    minmax(160px, 1fr)
                    auto;
                gap:12px;
                align-items:end;
            "
        >

            {{-- Search --}}

            <div>

                <label
                    for="search"
                    style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:700;
                    "
                >
                    Search
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search menus..."
                >

            </div>


            {{-- Dish --}}

            <div>

                <label
                    for="dish_id"
                    style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:700;
                    "
                >
                    Dish
                </label>

                <select id="dish_id" name="dish_id">

                    <option value="">
                        All Dishes
                    </option>

                    @foreach($dishes as $dish)

                        <option
                            value="{{ $dish->id }}"
                            @selected(request('dish_id') == $dish->id)
                        >
                            {{ $dish->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Status --}}

            <div>

                <label
                    for="status"
                    style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:700;
                    "
                >
                    Status
                </label>

                <select id="status" name="status">

                    <option value="">
                        All Statuses
                    </option>

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


            {{-- Filter button --}}

            <button
                type="submit"
                class="btn btn-secondary"
            >
                Filter
            </button>

        </div>

    </form>

</div>


{{-- Menus --}}

<div class="card">

    @if($menus->count())

        <div
            style="
                overflow-x:auto;
            "
        >

            <table style="width:100%; border-collapse:collapse;">

                <thead>

                    <tr>

                        <th
                            style="
                                text-align:left;
                                padding:12px;
                            "
                        >
                            Date
                        </th>

                        <th
                            style="
                                text-align:left;
                                padding:12px;
                            "
                        >
                            Time
                        </th>

                        <th
                            style="
                                text-align:left;
                                padding:12px;
                            "
                        >
                            Dishes
                        </th>

                        <th
                            style="
                                text-align:left;
                                padding:12px;
                            "
                        >
                            Planned Quantity
                        </th>

                        <th
                            style="
                                text-align:left;
                                padding:12px;
                            "
                        >
                            Status
                        </th>

                        <th
                            style="
                                text-align:right;
                                padding:12px;
                            "
                        >
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($menus as $menu)

                        <tr
                            style="
                                border-top:1px solid #E2E8F0;
                            "
                        >

                            {{-- Date --}}

                            <td style="padding:14px 12px;">

                                <strong>
                                    {{ $menu->service_date?->format('d/m/Y') ?? '—' }}
                                </strong>

                            </td>


                            {{-- Time --}}

                            <td style="padding:14px 12px;">

                                {{ $menu->service_time ?? '—' }}

                            </td>


                            {{-- Dishes --}}

                            <td style="padding:14px 12px;">

                                @if($menu->dishes->count())

                                    <div
                                        style="
                                            display:flex;
                                            flex-wrap:wrap;
                                            gap:6px;
                                        "
                                    >

                                        @foreach($menu->dishes as $dish)

                                            <span
                                                style="
                                                    display:inline-block;
                                                    padding:5px 9px;
                                                    border-radius:999px;
                                                    background:var(--primary-soft);
                                                    color:var(--primary-dark);
                                                    font-size:11px;
                                                    font-weight:700;
                                                "
                                            >
                                                {{ $dish->name }}
                                            </span>

                                        @endforeach

                                    </div>

                                @else

                                    <span
                                        style="
                                            color:var(--text-secondary);
                                            font-size:12px;
                                        "
                                    >
                                        No dishes
                                    </span>

                                @endif

                            </td>


                            {{-- Quantity --}}

                            <td style="padding:14px 12px;">

                                {{ $menu->planned_quantity }}

                            </td>


                            {{-- Status --}}

                            <td style="padding:14px 12px;">

                                @if($menu->is_active)

                                    <span
                                        style="
                                            display:inline-block;
                                            padding:6px 10px;
                                            border-radius:999px;
                                            background:rgba(22,163,74,.10);
                                            color:#16A34A;
                                            font-size:11px;
                                            font-weight:800;
                                        "
                                    >
                                        Active
                                    </span>

                                @else

                                    <span
                                        style="
                                            display:inline-block;
                                            padding:6px 10px;
                                            border-radius:999px;
                                            background:rgba(220,38,38,.10);
                                            color:#DC2626;
                                            font-size:11px;
                                            font-weight:800;
                                        "
                                    >
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}

                            <td
                                style="
                                    padding:14px 12px;
                                    text-align:right;
                                    white-space:nowrap;
                                "
                            >

                                <a
                                    href="{{ route($menuRoute . '.show', $menu) }}"
                                    class="btn btn-secondary"
                                    style="margin-right:5px;"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route($menuRoute . '.edit', $menu) }}"
                                    class="btn btn-primary"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route($menuRoute . '.destroy', $menu) }}"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this menu?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div
            style="
                padding:30px;
                text-align:center;
                color:var(--text-secondary);
            "
        >

            <div style="font-size:35px; margin-bottom:10px;">
                📅
            </div>

            <strong style="display:block; color:var(--text-primary);">
                No menus found
            </strong>

            <p>
                Create your first daily menu.
            </p>

            <a
                href="{{ route($menuRoute . '.create') }}"
                class="btn btn-primary"
            >
                + Create Menu
            </a>

        </div>

    @endif

</div>


<style>

    @media (max-width: 900px) {

        .card form > div {
            grid-template-columns: 1fr !important;
        }

    }

</style>

@endsection