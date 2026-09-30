<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Reservations - Madrassati</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #F3F6F9;
            color: #172033;
        }

        .header {
            background: #047857;
            color: white;
            padding: 20px;
        }

        .header-content {
            max-width: 1100px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .top-actions {
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-primary {
            background: #047857;
            color: white;
        }

        .btn-secondary {
            background: #64748B;
            color: white;
        }

        .btn-danger {
            background: #DC2626;
            color: white;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #DCFCE7;
            color: #166534;
        }

        .alert-error {
            background: #FEE2E2;
            color: #991B1B;
        }

        .reservation-grid {
            display: grid;
            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(300px, 1fr)
                );
            gap: 20px;
        }

        .reservation-card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .reservation-date {
            margin: 0;
            font-size: 21px;
        }

        .service-time {
            margin-top: 7px;
            color: #64748B;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-reserved {
            background: #D1FAE5;
            color: #047857;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .section-title {
            margin: 0 0 10px;
            font-size: 15px;
        }

        .dishes {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .dish {
            background: #F3F6F9;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 14px;
        }

        .reservation-info {
            border-top: 1px solid #E2E8F0;
            padding-top: 15px;
            color: #64748B;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .empty {
            background: white;
            padding: 60px 20px;
            border-radius: 12px;
            text-align: center;
        }

        .empty-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        @media (max-width: 600px) {

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .reservation-header {
                flex-direction: column;
            }

            .container {
                padding: 0 15px;
            }
        }
    </style>
</head>

<body>

    <header class="header">

        <div class="header-content">

            <div>
                <h1>📋 My Reservations</h1>

                <p>
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

    </header>


    <main class="container">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-error">
                {{ session('error') }}
            </div>

        @endif


        @if($reservations->count() > 0)

            <div class="reservation-grid">

                @foreach($reservations as $reservation)

                    <div class="reservation-card">

                        <div class="reservation-header">

                            <div>

                                <h2 class="reservation-date">
                                    📅
                                    {{ $reservation->menu->service_date->format('d/m/Y') }}
                                </h2>

                                @if($reservation->menu->service_time)

                                    <div class="service-time">

                                        🕐
                                        {{ \Carbon\Carbon::parse(
                                            $reservation->menu->service_time
                                        )->format('H:i') }}

                                    </div>

                                @endif

                            </div>


                            @if($reservation->status === 'reserved')

                                <span class="status status-reserved">
                                    RESERVED
                                </span>

                            @else

                                <span class="status status-cancelled">
                                    CANCELLED
                                </span>

                            @endif

                        </div>


                        <h3 class="section-title">
                            🍴 Dishes
                        </h3>


                        @if($reservation->menu->dishes->count() > 0)

                            <div class="dishes">

                                @foreach($reservation->menu->dishes as $dish)

                                    <span class="dish">
                                        {{ $dish->name }}
                                    </span>

                                @endforeach

                            </div>

                        @else

                            <p>
                                No dishes assigned.
                            </p>

                        @endif


                        <div class="reservation-info">

                            @if($reservation->reserved_at)

                                <div>
                                    Reserved on:
                                    <strong>
                                        {{ $reservation->reserved_at->format('d/m/Y H:i') }}
                                    </strong>
                                </div>

                            @endif

                        </div>


                        @if($reservation->status === 'reserved')

                            @if(
                                ! $reservation->menu->service_date->lt(today())
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
                                        ❌ Cancel Reservation
                                    </button>

                                </form>

                            @else

                                <p>
                                    This reservation can no longer
                                    be cancelled.
                                </p>

                            @endif

                        @else

                            <p style="color:#B91C1C;">
                                This reservation has been cancelled.
                            </p>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty">

                <div class="empty-icon">
                    📋
                </div>

                <h2>
                    No Reservations
                </h2>

                <p>
                    You don't have any meal reservations yet.
                </p>

                <br>

                <a
                    href="{{ route('eleve.menus') }}"
                    class="btn btn-primary"
                >
                    🍽️ View School Menus
                </a>

            </div>

        @endif

    </main>

</body>

</html>