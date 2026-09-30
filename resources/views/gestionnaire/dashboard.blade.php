@extends('layouts.admin')

@section('page_heading', 'Gestionnaire Dashboard')

@section('content')

<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .dashboard-title {
        margin: 0;
        font-size: 30px;
        font-weight: 800;
        color: #172033;
    }

    .dashboard-subtitle {
        margin: 6px 0 0;
        color: #64748B;
        font-size: 14px;
    }

    .today-badge {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
    }

    .today-icon {
        font-size: 22px;
    }

    .today-label {
        font-size: 11px;
        color: #64748B;
        text-transform: uppercase;
        font-weight: 700;
    }

    .today-date {
        font-size: 14px;
        color: #172033;
        font-weight: 700;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .stat-label {
        color: #64748B;
        font-size: 13px;
        font-weight: 700;
    }

    .stat-number {
        font-size: 32px;
        line-height: 1;
        font-weight: 800;
        color: #172033;
    }

    .stat-description {
        margin-top: 8px;
        color: #94A3B8;
        font-size: 12px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .icon-blue {
        background: #DBEAFE;
        color: #2563EB;
    }

    .icon-gold {
        background: #FEF3C7;
        color: #F59E0B;
    }

    .icon-green {
        background: #DCFCE7;
        color: #16A34A;
    }

    .icon-red {
        background: #FEE2E2;
        color: #DC2626;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .dashboard-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
    }

    .dashboard-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .card-title-area {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #D1FAE5;
        color: #087443;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .card-title {
        margin: 0;
        color: #172033;
        font-size: 17px;
        font-weight: 800;
    }

    .card-subtitle {
        margin: 3px 0 0;
        color: #64748B;
        font-size: 12px;
    }

    .active-badge {
        padding: 6px 10px;
        border-radius: 20px;
        background: #DCFCE7;
        color: #166534;
        font-size: 11px;
        font-weight: 800;
    }

    .dashboard-card-body {
        padding: 22px;
    }

    .service-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .service-icon {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .small-label {
        font-size: 11px;
        color: #64748B;
        text-transform: uppercase;
        font-weight: 800;
    }

    .service-time {
        margin-top: 4px;
        font-size: 25px;
        color: #087443;
        font-weight: 800;
    }

    .section-label {
        font-size: 12px;
        color: #64748B;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .dish-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .dish-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 13px 14px;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        background: #FFFFFF;
    }

    .dish-left {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .dish-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #ECFDF5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .dish-name {
        color: #172033;
        font-weight: 700;
        font-size: 14px;
    }

    .dish-type {
        color: #94A3B8;
        font-size: 11px;
        margin-top: 2px;
    }

    .dish-tag {
        background: #F1F5F9;
        color: #64748B;
        padding: 5px 8px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .operation-status {
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .status-ready {
        background: #ECFDF5;
        border: 1px solid #BBF7D0;
    }

    .status-progress {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
    }

    .status-complete {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
    }

    .status-none {
        background: #FFF7ED;
        border: 1px solid #FED7AA;
    }

    .status-content {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .status-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .status-title {
        font-weight: 800;
        font-size: 15px;
        color: #172033;
    }

    .status-text {
        margin-top: 3px;
        font-size: 12px;
        color: #64748B;
    }

    .operation-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .operation-stat {
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        background: #FFFFFF;
    }

    .operation-stat-label {
        color: #64748B;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .operation-stat-number {
        margin-top: 6px;
        color: #172033;
        font-size: 22px;
        font-weight: 800;
    }

    .progress-area {
        margin-top: 5px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 12px;
        color: #64748B;
        font-weight: 700;
    }

    .progress-bar {
        height: 9px;
        background: #E2E8F0;
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #087443;
        border-radius: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 35px 15px;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 800;
        color: #172033;
    }

    .empty-text {
        margin-top: 5px;
        color: #64748B;
        font-size: 13px;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .operation-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-title {
            font-size: 24px;
        }

        .dashboard-card-header {
            align-items: flex-start;
        }
    }
</style>

<div class="dashboard-header">

    <div>
        <h1 class="dashboard-title">Gestionnaire Dashboard</h1>
        <p class="dashboard-subtitle">
            Overview of today's school meal operations.
        </p>
    </div>

    <div class="today-badge">
        <div class="today-icon">📅</div>

        <div>
            <div class="today-label">Today</div>

            <div class="today-date">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

</div>


{{-- Statistics --}}

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Today's Reservations
                </div>

                <div class="stat-number">
                    {{ $todayReservations }}
                </div>

                <div class="stat-description">
                    Active reservations
                </div>
            </div>

            <div class="stat-icon icon-blue">
                🍽️
            </div>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Meals To Serve
                </div>

                <div class="stat-number">
                    {{ $todayMealsToServe }}
                </div>

                <div class="stat-description">
                    Today's meal operations
                </div>
            </div>

            <div class="stat-icon icon-gold">
                📋
            </div>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Served
                </div>

                <div class="stat-number">
                    {{ $todayServedMeals }}
                </div>

                <div class="stat-description">
                    Meals distributed
                </div>
            </div>

            <div class="stat-icon icon-green">
                ✓
            </div>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Not Served
                </div>

                <div class="stat-number">
                    {{ $todayNotServedMeals }}
                </div>

                <div class="stat-description">
                    Meals not distributed
                </div>
            </div>

            <div class="stat-icon icon-red">
                !
            </div>

        </div>

    </div>

</div>


{{-- Main dashboard --}}

<div class="dashboard-grid">


    {{-- Today's Menu --}}

    <div class="dashboard-card">

        <div class="dashboard-card-header">

            <div class="card-title-area">

                <div class="card-icon">
                    🍴
                </div>

                <div>

                    <h2 class="card-title">
                        Today's Menu
                    </h2>

                    <p class="card-subtitle">
                        School meal planned for today
                    </p>

                </div>

            </div>


            @if ($todayMenu)

                <span class="active-badge">
                    Active
                </span>

            @endif

        </div>


        <div class="dashboard-card-body">

            @if ($todayMenu)

                <div class="service-card">

                    <div class="service-icon">
                        🕐
                    </div>

                    <div class="small-label">
                        Service Time
                    </div>

                    <div class="service-time">
                        {{ $todayMenu->service_time
                            ? \Carbon\Carbon::parse($todayMenu->service_time)->format('H:i')
                            : 'Not specified' }}
                    </div>

                    @if ($todayMenu->planned_quantity)

                        <div style="margin-top: 8px; color: #64748B; font-size: 12px;">
                            Planned quantity:
                            <strong>
                                {{ $todayMenu->planned_quantity }}
                            </strong>
                        </div>

                    @endif

                </div>


                <div class="section-label">
                    Today's Dishes
                </div>


                @if ($todayMenu->dishes->count())

                    <div class="dish-list">

                        @foreach ($todayMenu->dishes as $dish)

                            <div class="dish-card">

                                <div class="dish-left">

                                    <div class="dish-icon">
                                        🍽️
                                    </div>

                                    <div>

                                        <div class="dish-name">
                                            {{ $dish->name }}
                                        </div>

                                        <div class="dish-type">
                                            {{ ucwords(str_replace('_', ' ', $dish->dish_type)) }}
                                        </div>

                                    </div>

                                </div>


                                <div class="dish-tag">
                                    {{ ucwords(str_replace('_', ' ', $dish->dish_type)) }}
                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            🍽️
                        </div>

                        <div class="empty-title">
                            No dishes assigned
                        </div>

                        <div class="empty-text">
                            This menu does not have any dishes yet.
                        </div>

                    </div>

                @endif


            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        📅
                    </div>

                    <div class="empty-title">
                        No menu for today
                    </div>

                    <div class="empty-text">
                        There is no active menu planned for today.
                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- Today's Operations --}}

    <div class="dashboard-card">

        <div class="dashboard-card-header">

            <div class="card-title-area">

                <div class="card-icon">
                    ⚙️
                </div>

                <div>

                    <h2 class="card-title">
                        Today's Operations
                    </h2>

                    <p class="card-subtitle">
                        Meal distribution progress
                    </p>

                </div>

            </div>

        </div>


        <div class="dashboard-card-body">


            @if ($operationsStatus === 'ready')

                <div class="operation-status status-ready">

                    <div class="status-content">

                        <div class="status-icon">
                            ✓
                        </div>

                        <div>

                            <div class="status-title">
                                Ready to serve
                            </div>

                            <div class="status-text">
                                The menu is ready and no meals have been distributed yet.
                            </div>

                        </div>

                    </div>

                </div>


            @elseif ($operationsStatus === 'in_progress')

                <div class="operation-status status-progress">

                    <div class="status-content">

                        <div class="status-icon">
                            ↻
                        </div>

                        <div>

                            <div class="status-title">
                                Distribution in progress
                            </div>

                            <div class="status-text">
                                Meals are currently being distributed.
                            </div>

                        </div>

                    </div>

                </div>


            @elseif ($operationsStatus === 'completed')

                <div class="operation-status status-complete">

                    <div class="status-content">

                        <div class="status-icon">
                            ✓
                        </div>

                        <div>

                            <div class="status-title">
                                Distribution completed
                            </div>

                            <div class="status-text">
                                Today's meal distribution has been completed.
                            </div>

                        </div>

                    </div>

                </div>


            @else

                <div class="operation-status status-none">

                    <div class="status-content">

                        <div class="status-icon">
                            !
                        </div>

                        <div>

                            <div class="status-title">
                                No menu today
                            </div>

                            <div class="status-text">
                                There is no active menu available for today.
                            </div>

                        </div>

                    </div>

                </div>

            @endif


            <div class="operation-stats">

                <div class="operation-stat">

                    <div class="operation-stat-label">
                        Reservations
                    </div>

                    <div class="operation-stat-number">
                        {{ $todayReservations }}
                    </div>

                </div>


                <div class="operation-stat">

                    <div class="operation-stat-label">
                        Served
                    </div>

                    <div class="operation-stat-number">
                        {{ $todayServedMeals }}
                    </div>

                </div>


                <div class="operation-stat">

                    <div class="operation-stat-label">
                        Not Served
                    </div>

                    <div class="operation-stat-number">
                        {{ $todayNotServedMeals }}
                    </div>

                </div>

            </div>


            @php
                $totalOperations = $todayServedMeals + $todayNotServedMeals;

                $progressPercentage = $todayReservations > 0
                    ? min(100, round(($totalOperations / $todayReservations) * 100))
                    : 0;
            @endphp


            <div class="progress-area">

                <div class="progress-header">

                    <span>
                        Distribution Progress
                    </span>

                    <span>
                        {{ $progressPercentage }}%
                    </span>

                </div>


                <div class="progress-bar">

                    <div
                        class="progress-fill"
                        style="width: {{ $progressPercentage }}%;">
                    </div>

                </div>

            </div>


        </div>

    </div>

</div>

@endsection