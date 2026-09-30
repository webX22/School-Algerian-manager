@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_heading', 'Admin Dashboard')

@section('content')

    {{-- Welcome --}}
    <div
        class="card"
        style="
            margin-bottom: 24px;
            background:
                linear-gradient(
                    135deg,
                    rgba(16, 185, 129, 0.12),
                    rgba(59, 130, 246, 0.08),
                    rgba(255, 255, 255, 0.80)
                );
        "
    >
        <div
            style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
            "
        >

            <div>

                <div
                    style="
                        color: var(--primary-dark);
                        font-size: 12px;
                        font-weight: 800;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        margin-bottom: 8px;
                    "
                >
                    Administration
                </div>

                <h1
                    style="
                        font-size: 28px;
                        margin-bottom: 8px;
                    "
                >
                    Welcome back, {{ auth()->user()->name }}
                </h1>

                <p
                    style="
                        color: var(--text-secondary);
                        font-size: 13px;
                        line-height: 1.6;
                    "
                >
                    Manage students, users, dishes, menus,
                    reservations and meal distribution from one place.
                </p>

            </div>

            <div
                style="
                    width: 72px;
                    height: 72px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    border-radius: 22px;
                    background:
                        linear-gradient(
                            135deg,
                            var(--primary),
                            var(--primary-dark)
                        );
                    color: white;
                    font-size: 30px;
                    box-shadow:
                        0 15px 30px rgba(16, 185, 129, 0.22);
                "
            >
                🏫
            </div>

        </div>
    </div>


    {{-- Statistics --}}
    <div
        class="dashboard-statistics"
        style="
            display: grid;
            grid-template-columns:
                repeat(4, minmax(0, 1fr));
            gap: 18px;
        "
    >

        {{-- Total Users --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Total Users
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $totalUsers }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: #3B82F6;
                        background:
                            rgba(59, 130, 246, 0.10);
                        font-size: 20px;
                    "
                >
                    👥
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                All registered accounts
            </div>

        </div>


        {{-- Students --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Students
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $totalStudents }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: var(--primary-dark);
                        background:
                            rgba(16, 185, 129, 0.10);
                        font-size: 20px;
                    "
                >
                    🎓
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                Registered students
            </div>

        </div>


        {{-- Gestionnaires --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Gestionnaires
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $totalGestionnaires }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: var(--gold);
                        background:
                            rgba(245, 158, 11, 0.10);
                        font-size: 20px;
                    "
                >
                    🧑‍💼
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                Meal management staff
            </div>

        </div>


        {{-- Administrators --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Administrators
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $totalAdministrators }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: #8B5CF6;
                        background:
                            rgba(139, 92, 246, 0.10);
                        font-size: 20px;
                    "
                >
                    🛡️
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                System administrators
            </div>

        </div>


        {{-- Today's Reservations --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Today's Reservations
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $todayReservations }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: var(--gold);
                        background:
                            rgba(245, 158, 11, 0.10);
                        font-size: 20px;
                    "
                >
                    📋
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                Active reservations for today
            </div>

        </div>


        {{-- Today's Served Meals --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Today's Served Meals
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $todayServedMeals }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: var(--primary-dark);
                        background:
                            rgba(16, 185, 129, 0.10);
                        font-size: 20px;
                    "
                >
                    🍴
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                Meals served today
            </div>

        </div>


        {{-- Today's Not Served Meals --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Today's Not Served
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $todayNotServedMeals }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: #EF4444;
                        background:
                            rgba(239, 68, 68, 0.10);
                        font-size: 20px;
                    "
                >
                    ⚠️
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                Meals not served today
            </div>

        </div>


        {{-- Weekly Reservations --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >

                <div>

                    <div
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                            font-weight: 700;
                        "
                    >
                        Weekly Reservations
                    </div>

                    <div
                        style="
                            margin-top: 8px;
                            font-size: 30px;
                            font-weight: 800;
                        "
                    >
                        {{ $weeklyReservations }}
                    </div>

                </div>

                <div
                    style="
                        width: 46px;
                        height: 46px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        color: #3B82F6;
                        background:
                            rgba(59, 130, 246, 0.10);
                        font-size: 20px;
                    "
                >
                    📊
                </div>

            </div>

            <div
                style="
                    margin-top: 14px;
                    color: var(--text-secondary);
                    font-size: 11px;
                "
            >
                Active reservations this week
            </div>

        </div>

    </div>


    {{-- Management Overview --}}
    <div
        class="management-overview"
        style="
            display: grid;
            grid-template-columns:
                minmax(0, 1.5fr)
                minmax(300px, 1fr);
            gap: 18px;
            margin-top: 18px;
        "
    >

        {{-- Main Overview --}}
        <div class="card">

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 15px;
                    margin-bottom: 20px;
                "
            >

                <div>

                    <h2
                        style="
                            font-size: 18px;
                            margin-bottom: 5px;
                        "
                    >
                        School Meal Management
                    </h2>

                    <p
                        style="
                            color: var(--text-secondary);
                            font-size: 12px;
                        "
                    >
                        Quick access to the main operations.
                    </p>

                </div>

                <span
                    style="
                        padding: 7px 10px;
                        border-radius: 999px;
                        color: var(--primary-dark);
                        background: var(--primary-soft);
                        font-size: 10px;
                        font-weight: 800;
                    "
                >
                    OPERATIONS
                </span>

            </div>


            <div
                style="
                    display: grid;
                    grid-template-columns:
                        repeat(2, minmax(0, 1fr));
                    gap: 12px;
                "
            >

                <a
                    href="{{ route('admin.dishes.index') }}"
                    style="
                        padding: 16px;
                        color: inherit;
                        text-decoration: none;
                        background:
                            rgba(16, 185, 129, 0.055);
                        border:
                            1px solid
                            rgba(16, 185, 129, 0.10);
                        border-radius: 15px;
                    "
                >
                    <div style="font-size: 22px;">
                        🍽️
                    </div>

                    <div
                        style="
                            margin-top: 9px;
                            font-size: 13px;
                            font-weight: 800;
                        "
                    >
                        Dishes
                    </div>

                    <div
                        style="
                            margin-top: 4px;
                            color: var(--text-secondary);
                            font-size: 11px;
                        "
                    >
                        Manage school meals
                    </div>
                </a>


                <a
                    href="{{ route('admin.menus.index') }}"
                    style="
                        padding: 16px;
                        color: inherit;
                        text-decoration: none;
                        background:
                            rgba(59, 130, 246, 0.055);
                        border:
                            1px solid
                            rgba(59, 130, 246, 0.10);
                        border-radius: 15px;
                    "
                >
                    <div style="font-size: 22px;">
                        📅
                    </div>

                    <div
                        style="
                            margin-top: 9px;
                            font-size: 13px;
                            font-weight: 800;
                        "
                    >
                        Daily Menus
                    </div>

                    <div
                        style="
                            margin-top: 4px;
                            color: var(--text-secondary);
                            font-size: 11px;
                        "
                    >
                        Plan daily meals
                    </div>
                </a>


                <a
                    href="{{ route('admin.reservations.index') }}"
                    style="
                        padding: 16px;
                        color: inherit;
                        text-decoration: none;
                        background:
                            rgba(245, 158, 11, 0.055);
                        border:
                            1px solid
                            rgba(245, 158, 11, 0.10);
                        border-radius: 15px;
                    "
                >
                    <div style="font-size: 22px;">
                        📋
                    </div>

                    <div
                        style="
                            margin-top: 9px;
                            font-size: 13px;
                            font-weight: 800;
                        "
                    >
                        Reservations
                    </div>

                    <div
                        style="
                            margin-top: 4px;
                            color: var(--text-secondary);
                            font-size: 11px;
                        "
                    >
                        Monitor meal reservations
                    </div>
                </a>


                <a
                    href="{{ route('admin.meal-distributions.index') }}"
                    style="
                        padding: 16px;
                        color: inherit;
                        text-decoration: none;
                        background:
                            rgba(139, 92, 246, 0.055);
                        border:
                            1px solid
                            rgba(139, 92, 246, 0.10);
                        border-radius: 15px;
                    "
                >
                    <div style="font-size: 22px;">
                        🍴
                    </div>

                    <div
                        style="
                            margin-top: 9px;
                            font-size: 13px;
                            font-weight: 800;
                        "
                    >
                        Meal Distribution
                    </div>

                    <div
                        style="
                            margin-top: 4px;
                            color: var(--text-secondary);
                            font-size: 11px;
                        "
                    >
                        Track meal distribution
                    </div>
                </a>

            </div>

        </div>


        {{-- Quick Actions --}}
        <div class="card">

            <h2
                style="
                    font-size: 18px;
                    margin-bottom: 5px;
                "
            >
                Quick Actions
            </h2>

            <p
                style="
                    color: var(--text-secondary);
                    font-size: 12px;
                    margin-bottom: 18px;
                "
            >
                Common administrative actions.
            </p>


            <div
                style="
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                "
            >

                <a
                    href="{{ route('users.create') }}"
                    class="btn btn-primary"
                    style="justify-content: flex-start;"
                >
                    👤
                    Add User
                </a>

                <a
                    href="{{ route('students.create') }}"
                    class="btn btn-secondary"
                    style="justify-content: flex-start;"
                >
                    🎓
                    Add Student
                </a>

                <a
                    href="{{ route('admin.dishes.create') }}"
                    class="btn btn-success"
                    style="justify-content: flex-start;"
                >
                    🍽️
                    Add Dish
                </a>

                <a
                    href="{{ route('admin.menus.create') }}"
                    class="btn btn-accent"
                    style="justify-content: flex-start;"
                >
                    📅
                    Create Menu
                </a>

            </div>

        </div>

    </div>


    {{-- System Overview --}}
    <div
        class="card"
        style="margin-top: 18px;"
    >

        <div
            style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                flex-wrap: wrap;
            "
        >

            <div>

                <h2
                    style="
                        font-size: 18px;
                        margin-bottom: 5px;
                    "
                >
                    System Overview
                </h2>

                <p
                    style="
                        color: var(--text-secondary);
                        font-size: 12px;
                        line-height: 1.6;
                    "
                >
                    Madrassati centralizes school meal planning,
                    reservations and distribution management.
                </p>

            </div>

            <div
                style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 9px 13px;
                    color: var(--primary-dark);
                    background: var(--primary-soft);
                    border-radius: 12px;
                    font-size: 11px;
                    font-weight: 700;
                "
            >
                <span class="status-dot"></span>
                System operational
            </div>

        </div>

    </div>


    <style>
        @media (max-width: 1100px) {
            .dashboard-statistics {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr)) !important;
            }

            .management-overview {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 700px) {
            .dashboard-statistics {
                grid-template-columns: 1fr !important;
            }

            .management-overview {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

@endsection