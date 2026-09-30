@extends('layouts.admin')

@section('title', 'My Reservations')

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
        <h1>📋 My Reservations</h1>

        <p style="color:var(--text-secondary); margin:0;">
            View and manage your meal reservations.
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
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($reservations->count())

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

        @foreach($reservations as $reservation)

            <div class="card">

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
                            {{ $reservation->menu->service_date->format('d/m/Y') }}
                        </h2>

                        @if($reservation->menu->service_time)
                            <p
                                style="
                                    margin:0;
                                    color:var(--text-secondary);
                                "
                            >
                                🕐
                                {{ \Carbon\Carbon::parse($reservation->menu->service_time)->format('H:i') }}
                            </p>
                        @endif

                    </div>

                    @if($reservation->status === 'reserved')

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
                            Reserved
                        </span>

                    @else

                        <span
                            style="
                                background:#FEE2E2;
                                color:#B91C1C;
                                padding:6px 10px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:700;
                            "
                        >
                            Cancelled
                        </span>

                    @endif

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

                    @if($reservation->menu->dishes->count())

                        <div
                            style="
                                display:flex;
                                flex-wrap:wrap;
                                gap:8px;
                            "
                        >

                            @foreach($reservation->menu->dishes as $dish)

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

                    @endif

                </div>

                <div
                    style="
                        padding-top:15px;
                        border-top:1px solid #E2E8F0;
                    "
                >

                    @if($reservation->reserved_at)

                        <p
                            style="
                                margin:0 0 12px;
                                color:var(--text-secondary);
                                font-size:14px;
                            "
                        >
                            Reserved:
                            {{ $reservation->reserved_at->format('d/m/Y H:i') }}
                        </p>

                    @endif

                    @if(
                        $reservation->status === 'reserved'
                        && ! $reservation->menu->service_date->lt(today())
                    )

                        <form
                            method="POST"
                            action="{{ route(
                                'eleve.reservations.cancel',
                                $reservation
                            ) }}"
                            onsubmit="return confirm('Are you sure you want to cancel this reservation?');"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                Cancel Reservation
                            </button>
                        </form>

                    @elseif($reservation->status === 'cancelled')

                        <p
                            style="
                                margin:0;
                                color:#B91C1C;
                                font-weight:600;
                            "
                        >
                            This reservation has been cancelled.
                        </p>

                    @else

                        <p
                            style="
                                margin:0;
                                color:var(--text-secondary);
                            "
                        >
                            This reservation can no longer be cancelled.
                        </p>

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
                📋
            </div>

            <h2>No reservations yet</h2>

            <p
                style="
                    color:var(--text-secondary);
                    margin-bottom:20px;
                "
            >
                You don't have any meal reservations yet.
            </p>

            <a
                href="{{ route('eleve.menus') }}"
                class="btn btn-primary"
            >
                View School Menus
            </a>
        </div>

    </div>

@endif

@endsection