@extends('layouts.admin')

@section('title', 'Student Dashboard')

@section('content')

<div style="margin-bottom:30px;">
    <h1 style="margin:0 0 8px;">
        🎓 Student Dashboard
    </h1>

    <p style="color:var(--text-secondary); margin:0;">
        Welcome to your Madrassati student dashboard.
    </p>
</div>

<div
    style="
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
        gap:20px;
        margin-bottom:30px;
    "
>

    <div class="card">

        <div
            style="
                display:flex;
                align-items:center;
                gap:15px;
                margin-bottom:15px;
            "
        >
            <div
                style="
                    width:50px;
                    height:50px;
                    border-radius:12px;
                    background:#D1FAE5;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:25px;
                "
            >
                🍽️
            </div>

            <div>
                <h2 style="margin:0;">
                    School Menus
                </h2>

                <p
                    style="
                        margin:5px 0 0;
                        color:var(--text-secondary);
                    "
                >
                    View available daily meals.
                </p>
            </div>
        </div>

        <a
            href="{{ route('eleve.menus') }}"
            class="btn btn-primary"
        >
            View Menus
        </a>

    </div>


    <div class="card">

        <div
            style="
                display:flex;
                align-items:center;
                gap:15px;
                margin-bottom:15px;
            "
        >
            <div
                style="
                    width:50px;
                    height:50px;
                    border-radius:12px;
                    background:#DBEAFE;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:25px;
                "
            >
                📋
            </div>

            <div>
                <h2 style="margin:0;">
                    My Reservations
                </h2>

                <p
                    style="
                        margin:5px 0 0;
                        color:var(--text-secondary);
                    "
                >
                    View and manage your reservations.
                </p>
            </div>
        </div>

        <a
            href="{{ route('eleve.reservations') }}"
            class="btn btn-primary"
        >
            My Reservations
        </a>

    </div>

</div>


<div class="card">

    <h2 style="margin:0 0 10px;">
        ℹ️ Student Area
    </h2>

    <p
        style="
            margin:0;
            color:var(--text-secondary);
            line-height:1.6;
        "
    >
        From this dashboard, you can view school menus,
        make meal reservations, and manage your own reservations.
    </p>

</div>

@endsection