<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $publicSettings['site_title'] ?? config('app.name', 'AgroVision AI') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body class="guest-body">
    <div class="guest-shell">
        <div class="guest-hero">
            <a href="{{ route('home') }}" class="brand-mark">
                <span class="brand-icon"><i class="fa-solid fa-seedling"></i></span>
                <div>
                    <span class="brand-name">{{ __('platform.brand.name') }}</span>
                    <small>{{ __('platform.brand.tagline') }}</small>
                </div>
            </a>
            <span class="hero-badge mt-4"><i class="fa-solid fa-sparkles"></i> Precision agriculture platform</span>
            <h1>Log in to your farm intelligence workspace.</h1>
            <p>Track weather, AI crop recommendations, mandi pricing, crop approvals, orders, disease detection, and expert workflows from one premium dashboard.</p>
            <div class="guest-metrics">
                <div class="mini-card">
                    <strong>120K+</strong>
                    <span>Connected farms</span>
                </div>
                <div class="mini-card">
                    <strong>AI</strong>
                    <span>Crop predictions</span>
                </div>
                <div class="mini-card">
                    <strong>24x7</strong>
                    <span>Weather signals</span>
                </div>
            </div>
        </div>
        <div class="guest-card">
            @include('partials.flash')
            {{ $slot }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
