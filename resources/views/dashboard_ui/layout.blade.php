@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }

    $user = auth()->user();
    $userName = $user?->name ?: 'User';
    $isAdmin = $user?->isAdmin() ?? false;
    $userRole = $isAdmin ? 'Admin' : 'Farmer';
    $nameParts = array_filter(preg_split('/\s+/', trim($userName)) ?: []);
    $userInitials = collect($nameParts)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');

    if ($userInitials === '') {
        $userInitials = 'U';
    }

    $navigationGroups = [
        [
            'items' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'dashboard'],
            ],
        ],
        [
            'title' => 'Smart Tools',
            'items' => [
                ['label' => 'Crop Recommendation', 'route' => 'dashboard.crop', 'icon' => 'crop'],
                ['label' => 'Yield Prediction', 'route' => 'dashboard.yield', 'icon' => 'yield'],
                ['label' => 'Disease Detection', 'route' => 'dashboard.disease', 'icon' => 'disease'],
                ['label' => 'Fertilizer Recommendation', 'route' => 'dashboard.fertilizer', 'icon' => 'fertilizer'],
                ['label' => 'Weather Forecast', 'route' => 'dashboard.weather', 'icon' => 'weather'],
                ['label' => 'Soil Health Check', 'route' => 'dashboard.soil', 'icon' => 'soil'],
            ],
        ],
        [
            'title' => 'Records',
            'items' => [
                ['label' => 'My History', 'route' => 'dashboard.history', 'icon' => 'history'],
                ['label' => 'Reports', 'route' => 'dashboard.reports', 'icon' => 'reports'],
                ['label' => 'Saved Results', 'route' => 'dashboard.saved', 'icon' => 'saved'],
            ],
        ],
        [
            'title' => 'Account',
            'items' => [
                ['label' => 'Profile', 'route' => 'dashboard.profile', 'icon' => 'profile'],
                ['label' => 'Settings', 'route' => 'dashboard.settings', 'icon' => 'settings'],
            ],
        ],
    ];

    $pageTitle = trim($__env->yieldContent('title', 'Dashboard'));
    $pageSubtitle = trim($__env->yieldContent('subtitle', 'Manage your farm operations in one place.'));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $pageTitle }} | {{ $brandName }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/dashboard-unified.css') }}">
        @stack('styles')
    </head>
    <body class="dash-body">
        <div class="dash-shell">
            <aside class="dash-sidebar" id="dashboardSidebar">
                <div class="dash-sidebar__panel">
                    <a class="dash-brand" href="{{ route('dashboard') }}">
                        <span class="dash-brand__mark" aria-hidden="true">
                            <svg viewBox="0 0 64 64">
                                <path d="M31 58V28" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                                <path d="M31 31C16 30 9 20 8 8c13 1 24 9 23 23Z" fill="#57bc36"/>
                                <path d="M33 34c15-2 23-10 24-23-13 1-24 9-24 23Z" fill="#12842a"/>
                                <path d="M21 45c-8-1-14-6-15-14 9 1 15 6 15 14Z" fill="#84d65d"/>
                            </svg>
                        </span>
                        <span class="dash-brand__copy">
                            <strong>{{ $brandName }}</strong>
                            <small>AI for Smarter Farming</small>
                        </span>
                    </a>

                    <nav class="dash-nav" aria-label="Dashboard navigation">
                        @foreach ($navigationGroups as $group)
                            <div class="dash-nav__group">
                                @if (!empty($group['title']))
                                    <p class="dash-nav__label">{{ $group['title'] }}</p>
                                @endif

                                @foreach ($group['items'] as $item)
                                    <a class="dash-nav__link{{ request()->routeIs($item['route']) ? ' is-active' : '' }}" href="{{ route($item['route']) }}">
                                        <span class="dash-nav__icon" aria-hidden="true">
                                            @include('dashboard_ui.partials.icon', ['icon' => $item['icon']])
                                        </span>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="dash-nav__group">
                            <a class="dash-nav__link" href="{{ route('contact') }}">
                                <span class="dash-nav__icon" aria-hidden="true">
                                    @include('dashboard_ui.partials.icon', ['icon' => 'support'])
                                </span>
                                <span>Support</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dash-nav__link dash-nav__button" type="submit">
                                    <span class="dash-nav__icon" aria-hidden="true">
                                        @include('dashboard_ui.partials.icon', ['icon' => 'logout'])
                                    </span>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>

                    <article class="dash-premium">
                        <div class="dash-premium__art" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <p class="dash-pill-text">Go Premium</p>
                        <h2>Unlock richer insights and priority support.</h2>
                        <p>Upgrade to access deeper analytics, saved reports, and advanced farm planning tools.</p>
                        <a class="dash-button dash-button--primary" href="{{ route('features') }}">Upgrade Now</a>
                    </article>
                </div>
            </aside>

            <div class="dash-main">
                <header class="dash-topbar">
                    <button class="dash-menu-button" type="button" data-sidebar-toggle aria-label="Open navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <label class="dash-search">
                        <span class="dash-search__icon" aria-hidden="true">
                            @include('dashboard_ui.partials.icon', ['icon' => 'search'])
                        </span>
                        <input type="search" placeholder="Search anything..." aria-label="Search dashboard">
                        <small>Ctrl K</small>
                    </label>

                    <div class="dash-topbar__actions">
                        @if ($isAdmin)
                            <a class="dash-website-pill dash-admin-pill" href="{{ route('admin.dashboard') }}">
                                <span class="dash-website-pill__icon" aria-hidden="true">
                                    @include('dashboard_ui.partials.icon', ['icon' => 'settings'])
                                </span>
                                <span>Admin Panel</span>
                            </a>
                        @endif

                        <a class="dash-website-pill" href="{{ route('home') }}" target="_blank" rel="noopener">
                            <span class="dash-website-pill__icon" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => 'website'])
                            </span>
                            <span>View Website</span>
                        </a>

                        <article class="dash-weather-pill">
                            <span class="dash-weather-pill__icon" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => 'weather-sun'])
                            </span>
                            <div>
                                <strong>24&deg;C</strong>
                                <small>Partly Cloudy</small>
                            </div>
                        </article>

                        <button class="dash-icon-button" type="button" aria-label="Open notifications">
                            @include('dashboard_ui.partials.icon', ['icon' => 'bell'])
                            <span>3</span>
                        </button>

                        <a class="dash-user-pill" href="{{ route('dashboard.profile') }}">
                            <span class="dash-user-pill__avatar">{{ $userInitials }}</span>
                            <span class="dash-user-pill__copy">
                                <strong>{{ $userName }}</strong>
                                <small>{{ $userRole }}</small>
                            </span>
                            <span class="dash-user-pill__chevron" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => 'chevron'])
                            </span>
                        </a>
                    </div>
                </header>

                <main class="dash-page">
                    <section class="dash-page-header">
                        <div>
                            <p class="dash-page-header__eyebrow">AgroVision Workspace</p>
                            <h1>{{ $pageTitle }}</h1>
                            <p>{{ $pageSubtitle }}</p>
                        </div>

                        @hasSection('header_actions')
                            <div class="dash-page-header__actions">
                                @yield('header_actions')
                            </div>
                        @endif
                    </section>

                    @yield('content')
                </main>
            </div>
        </div>

        <script src="{{ asset('js/dashboard-shell.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>
