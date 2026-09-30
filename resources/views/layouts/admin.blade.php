<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'Madrassati') - Madrassati</title>

<style>

    :root {
        --primary: #10B981;
        --primary-dark: #047857;
        --primary-soft: #D1FAE5;
        --navy: #0B1220;
        --navy-light: #172033;
        --blue: #3B82F6;
        --gold: #F59E0B;
        --danger: #EF4444;
        --success: #10B981;
        --background: #F3F6F9;
        --surface: rgba(255, 255, 255, 0.78);
        --surface-solid: #FFFFFF;
        --text: #172033;
        --text-secondary: #64748B;
        --muted: #94A3B8;
        --border: rgba(148, 163, 184, 0.20);
        --sidebar-width: 270px;
        --sidebar-collapsed: 86px;
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 22px;
        --shadow-soft: 0 10px 35px rgba(15, 23, 42, 0.06);
        --shadow-glass: 0 20px 50px rgba(15, 23, 42, 0.10);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        min-height: 100vh;
        font-family:
            Inter,
            ui-sans-serif,
            system-ui,
            -apple-system,
            BlinkMacSystemFont,
            "Segoe UI",
            sans-serif;

        background:
            radial-gradient(
                circle at 10% 10%,
                rgba(16, 185, 129, 0.10),
                transparent 30%
            ),
            radial-gradient(
                circle at 90% 10%,
                rgba(59, 130, 246, 0.08),
                transparent 30%
            ),
            var(--background);

        color: var(--text);
    }

    a {
        color: inherit;
    }

    button,
    input,
    select,
    textarea {
        font-family: inherit;
    }

    /* SIDEBAR */

    .sidebar {
        position: fixed;
        z-index: 1000;
        left: 18px;
        top: 18px;
        bottom: 18px;
        width: var(--sidebar-width);

        display: flex;
        flex-direction: column;

        padding: 18px;

        color: white;

        background:
            linear-gradient(
                145deg,
                rgba(11, 18, 32, 0.94),
                rgba(15, 34, 48, 0.88)
            );

        border: 1px solid rgba(255, 255, 255, 0.10);
        border-radius: 28px;

        box-shadow:
            0 25px 70px rgba(15, 23, 42, 0.20);

        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);

        transition:
            width 0.35s ease,
            transform 0.35s ease;
    }

    /* BRAND */

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 8px 8px 20px;
        margin-bottom: 14px;

        border-bottom:
            1px solid rgba(255, 255, 255, 0.09);
    }

    .brand-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        color: white;

        background:
            linear-gradient(
                135deg,
                #10B981,
                #059669
            );

        box-shadow:
            0 8px 25px rgba(16, 185, 129, 0.28);

        font-size: 21px;
        font-weight: 800;
    }

    .brand-text {
        overflow: hidden;
        white-space: nowrap;
    }

    .brand-title {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.4px;
    }

    .brand-subtitle {
        margin-top: 2px;
        color: rgba(255, 255, 255, 0.50);
        font-size: 11px;
        font-weight: 500;
    }

    /* NAVIGATION */

    .nav-section {
        margin: 12px 8px 8px;

        color: rgba(255, 255, 255, 0.35);

        font-size: 10px;
        font-weight: 700;

        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .sidebar-nav {
        flex: 1;

        overflow-y: auto;
        overflow-x: hidden;

        padding-right: 3px;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.12);
        border-radius: 20px;
    }

    .nav-link {
        position: relative;

        display: flex;
        align-items: center;
        gap: 12px;

        width: 100%;

        margin-bottom: 5px;

        padding: 11px 12px;

        color: rgba(255, 255, 255, 0.68);

        text-decoration: none;

        border: 1px solid transparent;
        border-radius: 14px;

        transition:
            background 0.2s ease,
            color 0.2s ease,
            transform 0.2s ease;
    }

    .nav-link:hover {
        color: white;

        background:
            rgba(255, 255, 255, 0.07);

        transform: translateX(2px);
    }

    .nav-link.active {
        color: white;

        background:
            linear-gradient(
                135deg,
                rgba(16, 185, 129, 0.24),
                rgba(16, 185, 129, 0.08)
            );

        border-color:
            rgba(16, 185, 129, 0.22);

        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    .nav-link.active::before {
        content: "";

        position: absolute;

        left: -1px;
        top: 10px;
        bottom: 10px;

        width: 3px;

        background: var(--primary);

        border-radius: 0 10px 10px 0;

        box-shadow:
            0 0 12px rgba(16, 185, 129, 0.8);
    }

    .nav-icon {
        width: 34px;
        height: 34px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.06);

        font-size: 16px;
    }

    .nav-link.active .nav-icon {
        background:
            rgba(16, 185, 129, 0.16);
    }

    .nav-label {
        overflow: hidden;

        font-size: 13px;
        font-weight: 600;

        white-space: nowrap;
    }

    /* USER */

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 12px;
        margin-top: 12px;

        background:
            rgba(255, 255, 255, 0.055);

        border:
            1px solid rgba(255, 255, 255, 0.08);

        border-radius: 16px;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        color: white;

        background:
            linear-gradient(
                135deg,
                #3B82F6,
                #6366F1
            );

        border-radius: 12px;

        font-size: 14px;
        font-weight: 800;
    }

    .user-info {
        min-width: 0;
    }

    .user-name {
        overflow: hidden;

        color: white;

        font-size: 12px;
        font-weight: 700;

        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .user-role {
        margin-top: 2px;

        color: rgba(255, 255, 255, 0.42);

        font-size: 10px;

        text-transform: capitalize;
    }

    /* LOGOUT */

    .logout {
        margin-top: 8px;
    }

    .logout button {
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        padding: 10px 12px;

        color: rgba(255, 255, 255, 0.65);

        background: transparent;

        border:
            1px solid rgba(255, 255, 255, 0.08);

        border-radius: 13px;

        font-size: 12px;
        font-weight: 600;

        cursor: pointer;

        transition: 0.2s ease;
    }

    .logout button:hover {
        color: white;

        background:
            rgba(239, 68, 68, 0.14);

        border-color:
            rgba(239, 68, 68, 0.25);
    }

    /* CONTENT */

    .content {
        min-height: 100vh;

        margin-left:
            calc(var(--sidebar-width) + 36px);

        padding: 18px 28px 40px;

        transition:
            margin-left 0.35s ease;
    }

    /* TOPBAR */

    .topbar {
        position: sticky;
        z-index: 100;

        top: 18px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        min-height: 68px;

        margin-bottom: 24px;

        padding: 12px 18px;

        background:
            rgba(255, 255, 255, 0.70);

        border:
            1px solid rgba(255, 255, 255, 0.75);

        border-radius: 20px;

        box-shadow:
            var(--shadow-soft);

        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mobile-menu,
    .sidebar-toggle {
        width: 40px;
        height: 40px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: var(--text);

        background:
            rgba(255, 255, 255, 0.75);

        border:
            1px solid var(--border);

        border-radius: 12px;

        cursor: pointer;

        transition: 0.2s ease;
    }

    .mobile-menu:hover,
    .sidebar-toggle:hover {
        color: var(--primary-dark);

        background: white;

        transform: translateY(-1px);
    }

    .mobile-menu {
        display: none;
    }

    .page-title {
        font-size: 17px;
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    .page-subtitle {
        margin-top: 2px;

        color: var(--text-secondary);

        font-size: 11px;
    }

    .topbar-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 8px 12px;

        color: var(--primary-dark);

        background:
            var(--primary-soft);

        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;
    }

    .status-dot {
        width: 7px;
        height: 7px;

        background: var(--primary);

        border-radius: 50%;

        box-shadow:
            0 0 0 4px rgba(16, 185, 129, 0.12);
    }

    /* CARDS */

    .card {
        padding: 24px;

        background:
            rgba(255, 255, 255, 0.78);

        border:
            1px solid rgba(255, 255, 255, 0.85);

        border-radius: var(--radius-lg);

        box-shadow:
            var(--shadow-soft);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    /* BUTTONS */

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        padding: 10px 16px;

        border: 0;
        border-radius: 12px;

        font-size: 13px;
        font-weight: 700;

        text-decoration: none;

        cursor: pointer;

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            opacity 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        color: white;

        background:
            linear-gradient(
                135deg,
                #10B981,
                #059669
            );

        box-shadow:
            0 8px 20px rgba(16, 185, 129, 0.20);
    }

    .btn-secondary {
        color: white;
        background: var(--blue);
    }

    .btn-danger {
        color: white;
        background: var(--danger);
    }

    .btn-success {
        color: white;
        background: var(--success);
    }

    .btn-accent {
        color: white;
        background: var(--gold);
    }

    .btn-sm {
        padding: 7px 11px;
        font-size: 12px;
        border-radius: 9px;
    }

    /* HEADINGS */

    h1,
    h2,
    h3 {
        color: var(--text);
        letter-spacing: -0.4px;
    }

    /* TABLES */

    .card table {
        overflow: hidden;

        width: 100%;

        border-collapse: separate;
        border-spacing: 0;

        background: transparent;

        border-radius: 14px;
    }

    table {
        width: 100%;
    }

    th {
        padding: 13px 14px;

        color: var(--text-secondary);

        background:
            rgba(241, 245, 249, 0.80);

        border-bottom:
            1px solid var(--border);

        text-align: left;

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        padding: 14px;

        border-bottom:
            1px solid var(--border);

        color: var(--text);

        font-size: 13px;
    }

    tbody tr {
        transition:
            background 0.2s ease;
    }

    tbody tr:hover {
        background:
            rgba(16, 185, 129, 0.035);
    }

    /* FORMS */

    input,
    select,
    textarea {
        width: 100%;

        padding: 11px 13px;

        color: var(--text);

        background:
            rgba(255, 255, 255, 0.85);

        border:
            1px solid var(--border);

        border-radius: 12px;

        font-size: 13px;

        outline: none;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--primary);

        box-shadow:
            0 0 0 4px rgba(16, 185, 129, 0.10);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    label {
        display: block;

        margin-bottom: 7px;

        color: var(--text);

        font-size: 12px;
        font-weight: 700;
    }

    .form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 20px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 10px;

        margin-top: 20px;

        flex-wrap: wrap;
    }

    /* ALERTS */

    .alert-success,
    .alert-danger {
        padding: 14px 17px;

        margin-bottom: 20px;

        border-radius: 14px;

        font-size: 13px;
        font-weight: 600;
    }

    .alert-success {
        color: #047857;

        background:
            rgba(209, 250, 229, 0.78);

        border:
            1px solid rgba(16, 185, 129, 0.20);
    }

    .alert-danger {
        color: #B91C1C;

        background:
            rgba(254, 226, 226, 0.80);

        border:
            1px solid rgba(239, 68, 68, 0.20);
    }

    /* COLLAPSED SIDEBAR */

    body.sidebar-collapsed .sidebar {
        width: var(--sidebar-collapsed);
    }

    body.sidebar-collapsed .content {
        margin-left:
            calc(var(--sidebar-collapsed) + 36px);
    }

    body.sidebar-collapsed .brand {
        justify-content: center;
    }

    body.sidebar-collapsed .brand-text,
    body.sidebar-collapsed .nav-label,
    body.sidebar-collapsed .nav-section,
    body.sidebar-collapsed .user-info,
    body.sidebar-collapsed .logout span {
        display: none;
    }

    body.sidebar-collapsed .sidebar-user {
        justify-content: center;
        padding: 8px;
    }

    body.sidebar-collapsed .nav-link {
        justify-content: center;
    }

    body.sidebar-collapsed .logout button {
        font-size: 0;
    }

    /* MOBILE */

    .sidebar-overlay {
        display: none;

        position: fixed;

        z-index: 999;

        inset: 0;

        background:
            rgba(15, 23, 42, 0.40);

        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    /* RESPONSIVE */

    @media (max-width: 900px) {

        .sidebar {
            left: 12px;
            top: 12px;
            bottom: 12px;

            transform: translateX(-125%);

            width: 270px;
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        .sidebar-overlay.active {
            display: block;
        }

        .content,
        body.sidebar-collapsed .content {
            margin-left: 0;

            padding:
                12px 14px 30px;
        }

        .sidebar-toggle {
            display: none;
        }

        .mobile-menu {
            display: flex;
        }

        .topbar {
            top: 12px;

            min-height: 62px;

            margin-bottom: 18px;

            border-radius: 17px;
        }

        .topbar-badge {
            display: none;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {

        .page-title {
            font-size: 15px;
        }

        .page-subtitle {
            font-size: 10px;
        }

        .card {
            padding: 17px;

            border-radius: 18px;
        }

        .form-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }

        table {
            min-width: 650px;
        }

        .card:has(table) {
            overflow-x: auto;
        }
    }

</style>


</head>

<body>


<!-- MOBILE OVERLAY -->

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
    onclick="closeMobileSidebar()">
</div>


<!-- SIDEBAR -->

<aside class="sidebar" id="sidebar">

    <!-- BRAND -->

    <div class="brand">

        <div class="brand-icon">
            M
        </div>

        <div class="brand-text">

            <div class="brand-title">
                Madrassati
            </div>

            <div class="brand-subtitle">
                School Meal Management
            </div>

        </div>

    </div>


    <!-- NAVIGATION -->

    <nav class="sidebar-nav">

        <div class="nav-section">
            Main
        </div>


        <!-- ADMIN -->

        @if (auth()->user()->role === 'admin')

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🏠
                </span>

                <span class="nav-label">
                    Dashboard
                </span>

            </a>


            <div class="nav-section">
                Management
            </div>


            <a
                href="{{ route('admin.dishes.index') }}"
                class="nav-link {{ request()->routeIs('admin.dishes.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🍽️
                </span>

                <span class="nav-label">
                    Dishes
                </span>

            </a>


            <a
                href="{{ route('admin.menus.index') }}"
                class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    📅
                </span>

                <span class="nav-label">
                    Daily Menus
                </span>

            </a>


            <a
                href="{{ route('admin.reservations.index') }}"
                class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    📋
                </span>

                <span class="nav-label">
                    Reservations
                </span>

            </a>


            <a
                href="{{ route('admin.meal-distributions.index') }}"
                class="nav-link {{ request()->routeIs('admin.meal-distributions.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🍴
                </span>

                <span class="nav-label">
                    Meal Distribution
                </span>

            </a>


            <div class="nav-section">
                Administration
            </div>


            <a
                href="{{ route('users.index') }}"
                class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    👥
                </span>

                <span class="nav-label">
                    Users
                </span>

            </a>


            <a
                href="{{ route('classes.index') }}"
                class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🏫
                </span>

                <span class="nav-label">
                    Classes
                </span>

            </a>


            <a
                href="{{ route('students.index') }}"
                class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🎓
                </span>

                <span class="nav-label">
                    Students
                </span>

            </a>

        @endif


        <!-- GESTIONNAIRE -->

        @if (auth()->user()->role === 'gestionnaire')

            <a
                href="{{ route('gestionnaire.dashboard') }}"
                class="nav-link {{ request()->routeIs('gestionnaire.dashboard') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🏠
                </span>

                <span class="nav-label">
                    Dashboard
                </span>

            </a>


            <div class="nav-section">
                Management
            </div>


            <a
                href="{{ route('gestionnaire.dishes.index') }}"
                class="nav-link {{ request()->routeIs('gestionnaire.dishes.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🍽️
                </span>

                <span class="nav-label">
                    Dishes
                </span>

            </a>


            <a
                href="{{ route('gestionnaire.menus.index') }}"
                class="nav-link {{ request()->routeIs('gestionnaire.menus.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    📅
                </span>

                <span class="nav-label">
                    Daily Menus
                </span>

            </a>


            <a
                href="{{ route('gestionnaire.reservations.index') }}"
                class="nav-link {{ request()->routeIs('gestionnaire.reservations.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    📋
                </span>

                <span class="nav-label">
                    Reservations
                </span>

            </a>


            <a
                href="{{ route('gestionnaire.meal-distributions.index') }}"
                class="nav-link {{ request()->routeIs('gestionnaire.meal-distributions.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🍴
                </span>

                <span class="nav-label">
                    Meal Distribution
                </span>

            </a>

        @endif


        <!-- ELEVE -->

        @if (auth()->user()->role === 'eleve')

            <a
                href="{{ route('eleve.dashboard') }}"
                class="nav-link {{ request()->routeIs('eleve.dashboard') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🏠
                </span>

                <span class="nav-label">
                    Dashboard
                </span>

            </a>


            <div class="nav-section">
                Student Area
            </div>


            <a
                href="{{ route('eleve.menus') }}"
                class="nav-link {{ request()->routeIs('eleve.menus') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🍽️
                </span>

                <span class="nav-label">
                    School Menus
                </span>

            </a>


            <a
                href="{{ route('eleve.reservations') }}"
                class="nav-link {{ request()->routeIs('eleve.reservations') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    📋
                </span>

                <span class="nav-label">
                    My Reservations
                </span>

            </a>

        @endif

    </nav>


    <!-- USER -->

    <div class="sidebar-user">

        <div class="user-avatar">

            {{ strtoupper(
                substr(
                    auth()->user()->name ?? 'U',
                    0,
                    1
                )
            ) }}

        </div>

        <div class="user-info">

            <div class="user-name">

                {{ auth()->user()->name ?? 'User' }}

            </div>

            <div class="user-role">

                {{ auth()->user()->role ?? 'User' }}

            </div>

        </div>

    </div>


    <!-- LOGOUT -->

    <div class="logout">

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button type="submit">

                <span>
                    ↪
                </span>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>


<!-- MAIN CONTENT -->

<main class="content">

    <!-- TOPBAR -->

    <div class="topbar">

        <div class="topbar-left">

            <button
                type="button"
                class="mobile-menu"
                onclick="openMobileSidebar()"
                aria-label="Open menu"
            >
                ☰
            </button>


            <button
                type="button"
                class="sidebar-toggle"
                onclick="toggleSidebar()"
                aria-label="Toggle sidebar"
            >
                ☰
            </button>


            <div>

                <div class="page-title">

                    @yield(
                        'page_heading',
                        'Madrassati'
                    )

                </div>

                <div class="page-subtitle">
                    School meal management system
                </div>

            </div>

        </div>


        <div class="topbar-badge">

            <span class="status-dot"></span>

            System Online

        </div>

    </div>


    <!-- SUCCESS -->

    @if (session('success'))

        <div class="alert-success">

            ✓ {{ session('success') }}

        </div>

    @endif


    <!-- ERROR -->

    @if (session('error'))

        <div class="alert-danger">

            ⚠ {{ session('error') }}

        </div>

    @endif


    <!-- PAGE CONTENT -->

    @yield('content')

</main>


<!-- JAVASCRIPT -->

<script>

    function toggleSidebar() {

        document.body.classList.toggle(
            'sidebar-collapsed'
        );

        localStorage.setItem(
            'madrassati_sidebar_collapsed',
            document.body.classList.contains(
                'sidebar-collapsed'
            )
        );

    }


    function openMobileSidebar() {

        document
            .getElementById('sidebar')
            .classList.add('mobile-open');

        document
            .getElementById('sidebarOverlay')
            .classList.add('active');

    }


    function closeMobileSidebar() {

        document
            .getElementById('sidebar')
            .classList.remove('mobile-open');

        document
            .getElementById('sidebarOverlay')
            .classList.remove('active');

    }


    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const collapsed =
                localStorage.getItem(
                    'madrassati_sidebar_collapsed'
                );

            if (
                collapsed === 'true' &&
                window.innerWidth > 900
            ) {

                document.body.classList.add(
                    'sidebar-collapsed'
                );

            }

        }
    );


    window.addEventListener(
        'resize',
        function () {

            if (window.innerWidth > 900) {

                closeMobileSidebar();

            }

        }
    );

</script>


</body>

</html>
