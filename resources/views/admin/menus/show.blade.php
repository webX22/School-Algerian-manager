@extends('layouts.admin')

@section('title', 'View Daily Menu')

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
        <h1>Daily Menu</h1>

        <p style="color:var(--text-secondary); margin:0;">
            View menu details and assigned dishes.
        </p>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <a
            href="{{ route($menuRoute . '.edit', $menu) }}"
            class="btn btn-primary"
        >
            ✏️ Edit
        </a>

        <a
            href="{{ route($menuRoute . '.index') }}"
            class="btn btn-secondary"
        >
            ← Back to Menus
        </a>

    </div>

</div>


<div class="card">

    {{-- Menu Information --}}

    <h2 style="font-size:18px; margin-bottom:20px;">
        Menu Information
    </h2>


    <div
        style="
            display:grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap:18px;
        "
    >

        {{-- Service Date --}}

        <div>

            <div
                style="
                    color:var(--text-secondary);
                    font-size:12px;
                    font-weight:700;
                    margin-bottom:5px;
                "
            >
                Service Date
            </div>

            <div style="font-size:15px; font-weight:700;">
                {{ $menu->service_date?->format('d/m/Y') ?? '—' }}
            </div>

        </div>


        {{-- Service Time --}}

        <div>

            <div
                style="
                    color:var(--text-secondary);
                    font-size:12px;
                    font-weight:700;
                    margin-bottom:5px;
                "
            >
                Service Time
            </div>

            <div style="font-size:15px; font-weight:700;">
                {{ $menu->service_time ?? '—' }}
            </div>

        </div>


        {{-- Planned Quantity --}}

        <div>

            <div
                style="
                    color:var(--text-secondary);
                    font-size:12px;
                    font-weight:700;
                    margin-bottom:5px;
                "
            >
                Planned Quantity
            </div>

            <div style="font-size:15px; font-weight:700;">
                {{ $menu->planned_quantity }}
            </div>

        </div>


        {{-- Status --}}

        <div>

            <div
                style="
                    color:var(--text-secondary);
                    font-size:12px;
                    font-weight:700;
                    margin-bottom:5px;
                "
            >
                Status
            </div>

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

        </div>

    </div>


    {{-- Notes --}}

    @if($menu->notes)

        <div style="margin-top:25px;">

            <div
                style="
                    color:var(--text-secondary);
                    font-size:12px;
                    font-weight:700;
                    margin-bottom:7px;
                "
            >
                Notes
            </div>

            <div
                style="
                    padding:14px;
                    background:#F8FAFC;
                    border-radius:10px;
                    line-height:1.6;
                "
            >
                {{ $menu->notes }}
            </div>

        </div>

    @endif


    {{-- Dishes --}}

    <div style="margin-top:30px;">

        <h2 style="font-size:18px; margin-bottom:15px;">
            Dishes
        </h2>

        @if($menu->dishes->count())

            <div
                style="
                    display:grid;
                    grid-template-columns:
                        repeat(
                            auto-fit,
                            minmax(220px, 1fr)
                        );
                    gap:12px;
                "
            >

                @foreach($menu->dishes as $dish)

                    <div
                        style="
                            padding:16px;
                            border:1px solid #E2E8F0;
                            border-radius:12px;
                            background:#FFFFFF;
                        "
                    >

                        <div
                            style="
                                font-size:15px;
                                font-weight:800;
                            "
                        >
                            🍽️ {{ $dish->name }}
                        </div>

                        @if($dish->dish_type)

                            <div
                                style="
                                    margin-top:6px;
                                    color:var(--text-secondary);
                                    font-size:11px;
                                "
                            >
                                {{ ucwords(str_replace('_', ' ', $dish->dish_type)) }}
                            </div>

                        @endif

                        @if($dish->description)

                            <div
                                style="
                                    margin-top:8px;
                                    color:var(--text-secondary);
                                    font-size:12px;
                                    line-height:1.5;
                                "
                            >
                                {{ $dish->description }}
                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div
                style="
                    padding:18px;
                    background:#F8FAFC;
                    border-radius:10px;
                    color:var(--text-secondary);
                "
            >
                No dishes assigned to this menu.
            </div>

        @endif

    </div>


    {{-- Delete --}}

    <div
        style="
            margin-top:30px;
            padding-top:20px;
            border-top:1px solid #E2E8F0;
        "
    >

        <form
            method="POST"
            action="{{ route($menuRoute . '.destroy', $menu) }}"
            onsubmit="return confirm('Are you sure you want to delete this menu?');"
        >

            @csrf

            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger"
            >
                🗑️ Delete Menu
            </button>

        </form>

    </div>

</div>


<style>

    @media (max-width: 700px) {

        .card > div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }

    }

</style>

@endsection