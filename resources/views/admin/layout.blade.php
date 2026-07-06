@php
    $brandName = config('app.name', 'AgroVision');
    $user = auth()->user();
    $pageTitle = trim($__env->yieldContent('title', 'Admin Panel'));
    $pageSubtitle = trim($__env->yieldContent('subtitle', 'Manage AgroVision operations, users, and system health.'));

    $navigation = [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'icon' => 'dashboard'],
        ['label' => 'Users', 'route' => 'admin.users', 'icon' => 'profile'],
        ['label' => 'Messages', 'route' => 'admin.contact-messages', 'icon' => 'reports'],
        ['label' => 'Reports', 'route' => 'admin.reports', 'icon' => 'reports'],
        ['label' => 'Disease Reports', 'route' => 'admin.disease.index', 'icon' => 'disease'],
        ['label' => 'Soil Reports', 'route' => 'admin.soil.index', 'icon' => 'soil'],
        ['label' => 'Fertilizers', 'route' => 'admin.fertilizer.master', 'icon' => 'fertilizer'],
        ['label' => 'Fertilizer Rules', 'route' => 'admin.fertilizer.rules', 'icon' => 'settings'],
        ['label' => 'Fertilizer Reports', 'route' => 'admin.fertilizer.reports', 'icon' => 'reports'],
        ['label' => 'Settings', 'route' => 'admin.settings', 'icon' => 'settings'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle }} | {{ $brandName }} Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/admin-panel.css') }}">
    </head>
    <body class="admin-body">
        <div class="admin-shell">
            <aside class="admin-sidebar" id="adminSidebar">
                <div class="admin-sidebar__panel">
                    <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                        <span class="admin-brand__mark" aria-hidden="true">
                            @include('dashboard_ui.partials.icon', ['icon' => 'spark'])
                        </span>
                        <span>
                            <strong>{{ $brandName }}</strong>
                            <small>Admin Control Center</small>
                        </span>
                    </a>

                    <nav class="admin-nav" aria-label="Admin navigation">
                        @foreach ($navigation as $item)
                            <a class="admin-nav__link{{ request()->routeIs($item['route']) ? ' is-active' : '' }}" href="{{ route($item['route']) }}">
                                <span class="admin-nav__icon" aria-hidden="true">
                                    @include('dashboard_ui.partials.icon', ['icon' => $item['icon']])
                                </span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>

                    <div class="admin-sidebar__footer">
                        <a class="admin-button admin-button--ghost admin-button--full" href="{{ route('dashboard') }}">Farmer Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="admin-button admin-button--dark admin-button--full" type="submit">Log Out</button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="admin-main">
                <header class="admin-topbar">
                    <button class="admin-menu-button" type="button" data-admin-sidebar-toggle aria-label="Open admin navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <div class="admin-topbar__copy">
                        <p class="admin-topbar__eyebrow">Protected Workspace</p>
                        <strong>{{ $pageTitle }}</strong>
                    </div>

                    <div class="admin-topbar__actions">
                        <div class="admin-status-pill">
                            <span class="admin-status-pill__dot"></span>
                            <span>MySQL: {{ config('database.connections.mysql.database') ?: 'agro' }}</span>
                        </div>
                        <div class="admin-user-pill">
                            <span class="admin-user-pill__avatar">{{ strtoupper(substr($user?->name ?? 'Admin', 0, 1)) }}</span>
                            <span>
                                <strong>{{ $user?->name ?? 'Admin User' }}</strong>
                                <small>Administrator</small>
                            </span>
                        </div>
                    </div>
                </header>

                <main class="admin-page">
                    <section class="admin-page-header">
                        <div>
                            <p class="admin-page-header__eyebrow">AgroVision Admin</p>
                            <h1>{{ $pageTitle }}</h1>
                            <p>{{ $pageSubtitle }}</p>
                        </div>

                        @hasSection('header_actions')
                            <div class="admin-page-header__actions">
                                @yield('header_actions')
                            </div>
                        @endif
                    </section>

                    @if (session('status'))
                        <div class="admin-flash">{{ session('status') }}</div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        <script src="{{ asset('js/admin-panel.js') }}" defer></script>
    </body>
</html>
