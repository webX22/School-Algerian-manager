@extends('layouts.admin')

@section('title', 'School Menus')

@section('content')

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
        <h1>🍽️ School Menus</h1>

        <p style="color:var(--text-secondary); margin:0;">
            View the available school meals and daily menus.
        </p>
    </div>

    <a
        href="{{ route('eleve.dashboard') }}"
        class="btn btn-secondary"
    >
        ← Dashboard
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="margin-bottom:20px;">
        {{ session('error') }}
    </div>
@endif

@if($menus->count())

    <div
        style="
            display:grid;
            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(280px, 1fr)
                );
            gap:20px;
        "
    >

        @foreach($menus as $menu)

            <div
                class="card"
                style="
                    position:relative;
                    overflow:hidden;
                "
            >

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:15px;
                        margin-bottom:18px;
                    "
                >

                    <div>

                        <h2 style="margin:0 0 6px;">
                            {{ $menu->service_date->format('d/m/Y') }}
                        </h2>

                        @if($menu->service_time)

                            <p
                                style="
                                    margin:0;
                                    color:var(--text-secondary);
                                "
                            >
                                🕐
                                {{ \Carbon\Carbon::parse($menu->service_time)->format('H:i') }}
                            </p>

                        @endif

                    </div>

                    <span
                        style="
                            background:#D1FAE5;
                            color:#047857;
                            padding:6px 10px;
                            border-radius:20px;
                            font-size:13px;
                            font-weight:700;
                        "
                    >
                        Available
                    </span>

                </div>

                <div style="margin-bottom:18px;">

                    <h3
                        style="
                            margin:0 0 10px;
                            font-size:16px;
                        "
                    >
                        🍴 Dishes
                    </h3>

                    @if($menu->dishes->count())

                        <div
                            style="
                                display:flex;
                                flex-wrap:wrap;
                                gap:8px;
                            "
                        >

                            @foreach($menu->dishes as $dish)

                                <span
                                    style="
                                        background:#F3F6F9;
                                        color:#172033;
                                        padding:7px 10px;
                                        border-radius:8px;
                                        font-size:14px;
                                    "
                                >
                                    {{ $dish->name }}
                                </span>

                            @endforeach

                        </div>

                    @else

                        <p
                            style="
                                color:var(--text-secondary);
                                margin:0;
                            "
                        >
                            No dishes assigned.
                        </p>

                    @endif

                </div>

                @if($menu->notes)

                    <div
                        style="
                            padding:12px;
                            background:#F8FAFC;
                            border-radius:10px;
                            margin-bottom:18px;
                        "
                    >

                        <strong>Notes:</strong>

                        <div
                            style="
                                margin-top:5px;
                                color:var(--text-secondary);
                            "
                        >
                            {{ $menu->notes }}
                        </div>

                    </div>

                @endif

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        gap:15px;
                        padding-top:15px;
                        border-top:1px solid #E2E8F0;
                        flex-wrap:wrap;
                    "
                >

                    <span
                        style="
                            color:var(--text-secondary);
                            font-size:14px;
                        "
                    >
                        Planned meals:

                        <strong>
                            {{ $menu->planned_quantity }}
                        </strong>
                    </span>

                    @php
                        $existingReservation = \App\Models\Reservation::where(
                            'student_id',
                            auth()->user()->student?->id
                        )
                        ->where(
                            'menu_id',
                            $menu->id
                        )
                        ->first();
                    @endphp

                    @if($existingReservation?->status === 'reserved')

                        <span
                            style="
                                background:#D1FAE5;
                                color:#047857;
                                padding:8px 12px;
                                border-radius:8px;
                                font-size:14px;
                                font-weight:700;
                            "
                        >
                            ✓ Reserved
                        </span>

                    @else

                        <form
                            method="POST"
                            action="{{ route(
                                'eleve.reservations.store',
                                $menu
                            ) }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Reserve
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="card">

        <div
            style="
                text-align:center;
                padding:50px 20px;
            "
        >

            <div
                style="
                    font-size:50px;
                    margin-bottom:15px;
                "
            >
                🍽️
            </div>

            <h2>No menus available</h2>

            <p
                style="
                    color:var(--text-secondary);
                    margin:0;
                "
            >
                There are currently no upcoming school menus.
            </p>

        </div>

    </div>

@endif

<style>

    @media (max-width: 700px) {

        .card {
            width: 100%;
        }

    }

</style>

@endsection