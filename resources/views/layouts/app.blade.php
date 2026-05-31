<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? ($publicSettings['site_title'] ?? config('app.name', 'AgroVision AI')) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <script>
        tailwind = {
            config: {
                corePlugins: {
                    preflight: false,
                },
                theme: {
                    extend: {
                        colors: {
                            agro: {
                                primary: '#2E7D32',
                                light: '#81C784',
                                dark: '#1B5E20',
                                night: '#0F172A',
                                panel: '#111827',
                            },
                        },
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
@php($user = auth()->user())
<body class="{{ $user ? 'app-body' : 'public-site-body' }}">
    @if($user)
        <div class="app-backdrop">
            <span class="orb orb-one"></span>
            <span class="orb orb-two"></span>
            <span class="orb orb-three"></span>
            <div class="noise-layer"></div>
        </div>
    @endif

    @if($user)
        <div class="app-shell">
            <aside class="sidebar-panel">
                <div>
                    <a href="{{ route('home') }}" class="brand-mark">
                        <span class="brand-icon"><i class="fa-solid fa-seedling"></i></span>
                        <div>
                            <span class="brand-name">{{ __('platform.brand.name') }}</span>
                            <small>{{ __('platform.brand.tagline') }}</small>
                        </div>
                    </a>

                    <div class="sidebar-section">
                        <span class="sidebar-label">Control Center</span>
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('farmer.dashboard') || request()->routeIs('expert.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-line"></i> Smart Overview
                        </a>

                        @if($user->hasRole('Admin'))
                            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users-gear"></i> User Control</a>
                            <a href="{{ route('admin.crops.index') }}" class="sidebar-link {{ request()->routeIs('admin.crops.*') ? 'active' : '' }}"><i class="fa-solid fa-leaf"></i> Crop Approvals</a>
                            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-basket-shopping"></i> Revenue Ops</a>
                            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="fa-solid fa-file-waveform"></i> Reports</a>
                            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="fa-solid fa-sliders"></i> Settings</a>
                        @endif

                        @if($user->hasRole('Farmer'))
                            <a href="{{ route('farmer.crops.index') }}" class="sidebar-link {{ request()->routeIs('farmer.crops.*') ? 'active' : '' }}"><i class="fa-solid fa-tractor"></i> Crop Inventory</a>
                            <a href="{{ route('farmer.intelligence.index') }}" class="sidebar-link {{ request()->routeIs('farmer.intelligence.*') || request()->routeIs('farmer.soil-reports.*') ? 'active' : '' }}"><i class="fa-solid fa-brain"></i> AI Intelligence</a>
                            <a href="{{ route('farmer.orders.index') }}" class="sidebar-link {{ request()->routeIs('farmer.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-receipt"></i> Sales Orders</a>
                            <a href="{{ route('farmer.disease-reports.index') }}" class="sidebar-link {{ request()->routeIs('farmer.disease-reports.*') ? 'active' : '' }}"><i class="fa-solid fa-shield-virus"></i> Disease Lab</a>
                            <a href="{{ route('farmer.questions.index') }}" class="sidebar-link {{ request()->routeIs('farmer.questions.*') ? 'active' : '' }}"><i class="fa-solid fa-comments"></i> Expert Help</a>
                        @endif

                        @if($user->hasRole('Buyer'))
                            <a href="{{ route('buyer.marketplace.index') }}" class="sidebar-link {{ request()->routeIs('buyer.marketplace.*') ? 'active' : '' }}"><i class="fa-solid fa-store"></i> Marketplace</a>
                            <a href="{{ route('buyer.cart.index') }}" class="sidebar-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
                            <a href="{{ route('buyer.orders.index') }}" class="sidebar-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-box-open"></i> Order Tracking</a>
                        @endif

                        @if($user->hasRole('Expert'))
                            <a href="{{ route('expert.questions.index') }}" class="sidebar-link {{ request()->routeIs('expert.questions.*') ? 'active' : '' }}"><i class="fa-solid fa-stethoscope"></i> Consultations</a>
                        @endif
                    </div>

                    <div class="sidebar-section">
                        <span class="sidebar-label">Ecosystem</span>
                        <a href="{{ route('weather.index') }}" class="sidebar-link {{ request()->routeIs('weather.*') ? 'active' : '' }}"><i class="fa-solid fa-cloud-sun-rain"></i> Weather Intel</a>
                        <a href="{{ route('community.index') }}" class="sidebar-link {{ request()->routeIs('community.*') ? 'active' : '' }}"><i class="fa-solid fa-user-group"></i> Community Feed</a>
                        <a href="{{ route('auctions.index') }}" class="sidebar-link {{ request()->routeIs('auctions.*') ? 'active' : '' }}"><i class="fa-solid fa-gavel"></i> Live Auctions</a>
                        <a href="{{ route('buyer.marketplace.index') }}" class="sidebar-link {{ request()->routeIs('buyer.marketplace.*') ? 'active' : '' }}"><i class="fa-solid fa-wheat-awn"></i> Agri Market</a>
                    </div>
                </div>

                <div class="profile-card">
                    <div class="d-flex align-items-center gap-3">
                        <img class="avatar-circle" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/images/crop-placeholder.svg') }}" alt="{{ $user->name }}">
                        <div>
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <small class="text-secondary">{{ $user->primaryRole() }}</small>
                        </div>
                    </div>
                    <div class="status-chip mt-3">
                        <i class="fa-solid fa-satellite-dish"></i>
                        <span>Connected to smart agriculture network</span>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm w-100">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm w-100">Logout</button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="main-panel">
                <nav class="topbar">
                    <div>
                        <h1 class="page-title">{{ $pageTitle ?? 'AgroVision AI Command Center' }}</h1>
                        <p class="page-subtitle">{{ $pageSubtitle ?? 'Real-time crop intelligence, marketplace activity, and farm operations in one place.' }}</p>
                    </div>
                    <div class="topbar-actions">
                        <form action="{{ route('locale.update') }}" method="POST" class="locale-form">
                            @csrf
                            <select name="locale" class="form-select form-select-sm locale-select" onchange="this.form.submit()">
                                @foreach($availableLocales as $localeCode => $localeLabel)
                                    <option value="{{ $localeCode }}" @selected($currentLocale === $localeCode)>{{ $localeLabel }}</option>
                                @endforeach
                            </select>
                        </form>
                        <button class="btn btn-outline-light btn-sm" id="themeToggle" type="button"><i class="fa-solid fa-moon"></i></button>
                        <a href="{{ route('community.index') }}" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-user-group me-1"></i> Community</a>
                        <a href="{{ route('auctions.index') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-gavel me-1"></i> Live Market</a>
                        <div class="dropdown">
                            <button class="btn btn-outline-light btn-sm position-relative" data-bs-toggle="dropdown" type="button" id="notificationButton">
                                <i class="fa-regular fa-bell"></i>
                                <span class="notification-badge d-none" id="notificationCount"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end notification-menu p-0">
                                <div class="notification-header d-flex justify-content-between align-items-center">
                                    <strong>Notifications</strong>
                                    <button class="btn btn-link btn-sm text-success text-decoration-none p-0" id="markNotificationsRead" type="button">Mark all read</button>
                                </div>
                                <div id="notificationList" class="notification-list">
                                    <div class="p-3 text-secondary">No new notifications yet.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <main class="content-wrapper">
                    @include('partials.flash')
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <div class="public-site-shell">
            <header class="public-site-header">
                <div class="public-site-header__inner">
                    <a href="{{ route('home') }}" class="brand-mark public-brand">
                        <span class="brand-icon"><i class="fa-solid fa-seedling"></i></span>
                        <div>
                            <span class="brand-name">{{ __('platform.brand.name') }}</span>
                            <small>{{ __('platform.brand.tagline') }}</small>
                        </div>
                    </a>

                    <nav class="public-site-nav">
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('home') }}#story">Story</a>
                        <a href="{{ route('home') }}#products">Products</a>
                        <a href="{{ route('home') }}#network">Network</a>
                        <a href="{{ route('home') }}#news">News</a>
                        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    </nav>

                    <div class="public-site-actions">
                        <form action="{{ route('locale.update') }}" method="POST" class="locale-form">
                            @csrf
                            <select name="locale" class="form-select form-select-sm locale-select" onchange="this.form.submit()">
                                @foreach($availableLocales as $localeCode => $localeLabel)
                                    <option value="{{ $localeCode }}" @selected($currentLocale === $localeCode)>{{ $localeLabel }}</option>
                                @endforeach
                            </select>
                        </form>
                        <a href="{{ route('buyer.marketplace.index') }}" class="btn btn-outline-light btn-sm">Marketplace</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">{{ __('platform.nav.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-success btn-sm">Get Started</a>
                    </div>
                </div>
            </header>

            <main class="public-site-main">
                <div class="public-site-frame">
                    @include('partials.flash')
                    @yield('content')
                </div>
            </main>

            <footer class="public-site-footer">
                <div class="public-site-footer__inner">
                    <div class="public-site-footer__brand">
                        <a href="{{ route('home') }}" class="brand-mark public-brand">
                            <span class="brand-icon"><i class="fa-solid fa-seedling"></i></span>
                            <div>
                                <span class="brand-name">{{ __('platform.brand.name') }}</span>
                                <small>{{ __('platform.brand.tagline') }}</small>
                            </div>
                        </a>
                        <p class="mb-0">Decision support, weather intelligence, digital trading, and community collaboration for modern agri teams.</p>
                    </div>

                    <div class="public-site-footer__links">
                        <div>
                            <span class="public-site-tag">Explore</span>
                            <a href="{{ route('home') }}#story">Why AgroVision</a>
                            <a href="{{ route('home') }}#products">Products</a>
                            <a href="{{ route('home') }}#network">Network</a>
                        </div>
                        <div>
                            <span class="public-site-tag">Platform</span>
                            <a href="{{ route('weather.index') }}">Weather</a>
                            <a href="{{ route('community.index') }}">Community</a>
                            <a href="{{ route('auctions.index') }}">Auctions</a>
                        </div>
                        <div class="public-site-footer__cta">
                            <span class="public-site-tag">Need a walkthrough?</span>
                            <p class="mb-0">Talk with the team about onboarding farmers, buyers, and experts into one connected workflow.</p>
                            <a href="{{ route('contact') }}" class="btn btn-success btn-sm">Book a demo</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
