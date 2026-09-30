<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Gestionnaire Dashboard') - Madrassati
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        :root {
            --g-primary: #0F766E;
            --g-primary-dark: #115E59;
            --g-primary-soft: #CCFBF1;

            --g-blue: #2563EB;
            --g-orange: #F59E0B;
            --g-red: #DC2626;

            --g-background: #F4F7F8;
            --g-card: #FFFFFF;

            --g-text: #172033;
            --g-muted: #64748B;

            --g-border: #E2E8F0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--g-background);
            color: var(--g-text);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        .gestionnaire-layout {
            min-height: 100vh;
        }

        /* Top Navigation */

        .gestionnaire-topbar {
            height: 72px;

            background: rgba(255, 255, 255, 0.94);

            border-bottom: 1px solid var(--g-border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 28px;

            position: sticky;
            top: 0;

            z-index: 100;
        }

        .gestionnaire-brand {
            display: flex;
            align-items: center;

            gap: 12px;

            text-decoration: none;
            color: inherit;
        }

        .gestionnaire-logo {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    var(--g-primary),
                    var(--g-primary-dark)
                );

            color: white;

            font-size: 20px;

            box-shadow:
                0 8px 20px rgba(15, 118, 110, 0.20);
        }

        .gestionnaire-brand-text {
            font-size: 17px;
            font-weight: 800;

            letter-spacing: -0.3px;
        }

        .gestionnaire-brand-subtitle {
            color: var(--g-muted);

            font-size: 10px;

            margin-top: 1px;
        }

        /* User Menu */

        .gestionnaire-user-wrapper {
            position: relative;
        }

        .gestionnaire-user-button {
            border: 0;
            background: transparent;

            display: flex;
            align-items: center;

            gap: 10px;

            padding: 6px 8px;

            border-radius: 14px;

            cursor: pointer;

            color: inherit;
        }

        .gestionnaire-user-button:hover {
            background: #F1F5F9;
        }

        .gestionnaire-avatar {
            width: 40px;
            height: 40px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--g-primary-soft);

            color: var(--g-primary-dark);

            font-size: 14px;
            font-weight: 800;
        }

        .gestionnaire-user-info {
            text-align: left;
        }

        .gestionnaire-user-name {
            font-size: 13px;
            font-weight: 800;
        }

        .gestionnaire-user-role {
            color: var(--g-muted);

            font-size: 10px;

            margin-top: 2px;
        }

        .gestionnaire-chevron {
            font-size: 12px;
            color: var(--g-muted);
        }

        /* Dropdown */

        .gestionnaire-dropdown {
            display: none;

            position: absolute;

            right: 0;
            top: calc(100% + 10px);

            width: 220px;

            background: white;

            border: 1px solid var(--g-border);

            border-radius: 16px;

            padding: 8px;

            box-shadow:
                0 20px 45px rgba(15, 23, 42, 0.12);

            z-index: 200;
        }

        .gestionnaire-dropdown.show {
            display: block;
        }

        .gestionnaire-dropdown-header {
            padding: 10px 12px 12px;

            border-bottom: 1px solid var(--g-border);

            margin-bottom: 6px;
        }

        .gestionnaire-dropdown-header strong {
            display: block;

            font-size: 13px;
        }

        .gestionnaire-dropdown-header span {
            display: block;

            margin-top: 3px;

            color: var(--g-muted);

            font-size: 10px;
        }

        .gestionnaire-dropdown a,
        .gestionnaire-dropdown button {
            width: 100%;

            display: flex;
            align-items: center;

            gap: 10px;

            padding: 11px 12px;

            border: 0;

            background: transparent;

            border-radius: 10px;

            color: var(--g-text);

            text-decoration: none;

            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            text-align: left;
        }

        .gestionnaire-dropdown a:hover,
        .gestionnaire-dropdown button:hover {
            background: #F8FAFC;
        }

        .gestionnaire-dropdown .logout {
            color: var(--g-red);
        }

        /* Main */

        .gestionnaire-main {
            max-width: 1400px;

            margin: 0 auto;

            padding: 32px 28px 50px;
        }

        .gestionnaire-page-header {
            margin-bottom: 24px;
        }

        .gestionnaire-page-header h1 {
            margin: 0;

            font-size: 28px;
            font-weight: 800;

            letter-spacing: -0.5px;
        }

        .gestionnaire-page-header p {
            margin: 7px 0 0;

            color: var(--g-muted);

            font-size: 13px;
        }

        /* Responsive */

        @media (max-width: 700px) {

            .gestionnaire-topbar {
                padding: 0 16px;
            }

            .gestionnaire-user-info {
                display: none;
            }

            .gestionnaire-main {
                padding: 24px 16px 40px;
            }

            .gestionnaire-page-header h1 {
                font-size: 23px;
            }
        }

    </style>

</head>

<body>

    <div class="gestionnaire-layout">

        <!-- Top Navigation -->

        <header class="gestionnaire-topbar">

            <a
                href="{{ route('gestionnaire.dashboard') }}"
                class="gestionnaire-brand"
            >

                <div class="gestionnaire-logo">
                    🍽️
                </div>

                <div>

                    <div class="gestionnaire-brand-text">
                        Madrassati
                    </div>

                    <div class="gestionnaire-brand-subtitle">
                        Meal Management
                    </div>

                </div>

            </a>


            <!-- User Menu -->

            <div class="gestionnaire-user-wrapper">

                <button
                    type="button"
                    class="gestionnaire-user-button"
                    onclick="toggleGestionnaireMenu()"
                >

                    <div class="gestionnaire-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="gestionnaire-user-info">

                        <div class="gestionnaire-user-name">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="gestionnaire-user-role">
                            Gestionnaire
                        </div>

                    </div>

                    <div class="gestionnaire-chevron">
                        ▾
                    </div>

                </button>


                <!-- Dropdown -->

                <div
                    id="gestionnaireUserMenu"
                    class="gestionnaire-dropdown"
                >

                    <div class="gestionnaire-dropdown-header">

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            Gestionnaire account
                        </span>

                    </div>


                    <a href="#">
                        👤
                        <span>My Profile</span>
                    </a>


                    <a href="#">
                        ⚙️
                        <span>Settings</span>
                    </a>


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="logout"
                        >
                            🚪
                            <span>Logout</span>
                        </button>

                    </form>

                </div>

            </div>

        </header>


        <!-- Main Content -->

        <main class="gestionnaire-main">

            @yield('content')

        </main>

    </div>


    <script>

        function toggleGestionnaireMenu() {

            const menu =
                document.getElementById('gestionnaireUserMenu');

            menu.classList.toggle('show');
        }


        document.addEventListener('click', function (event) {

            const wrapper =
                document.querySelector(
                    '.gestionnaire-user-wrapper'
                );

            const menu =
                document.getElementById(
                    'gestionnaireUserMenu'
                );

            if (
                wrapper &&
                menu &&
                !wrapper.contains(event.target)
            ) {
                menu.classList.remove('show');
            }

        });

    </script>

</body>

</html>