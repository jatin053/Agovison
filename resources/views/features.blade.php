@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }

    $dashboardUrl = auth()->check() ? route('dashboard') : null;
    $serviceLinks = array_map(
        fn ($label) => [
            'label' => $label,
            'href' => route('services') . '#' . \Illuminate\Support\Str::slug($label),
        ],
        [
            'Crop Recommendation',
            'Yield Prediction',
            'Disease Detection',
            'Fertilizer Recommendation',
            'Weather Forecast',
            'Farm Reports',
        ]
    );

    $images = [
        'hero' => 'https://plus.unsplash.com/premium_photo-1661661721305-8dfeaeea99d8?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'featureCrop' => 'https://images.unsplash.com/photo-1649531375189-42cb96d001c0?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'featureYield' => 'https://images.pexels.com/photos/9719550/pexels-photo-9719550.jpeg?cs=srgb&dl=pexels-sunbeam-9719550.jpg&fm=jpg',
        'featureDisease' => 'https://images.unsplash.com/photo-1758047920248-839ca7256a5c?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'featureFertilizer' => 'https://plus.unsplash.com/premium_photo-1747064333791-3698d2ffb3b6?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'featureWeather' => 'https://images.pexels.com/photos/33677662/pexels-photo-33677662.jpeg?cs=srgb&dl=pexels-ashish-singh-2155348388-33677662.jpg&fm=jpg',
        'featureDashboard' => 'https://plus.unsplash.com/premium_photo-1682092112837-3dcf3e85ea6c?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'featureConsult' => 'https://plus.unsplash.com/premium_photo-1664476842335-abe84418c76d?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
    ];

    $featureCards = [
        [
            'icon' => 'crop',
            'title' => 'Crop Recommendation',
            'subtitle' => 'Soil + season planning',
            'copy' => 'Get the best crop suggestions based on soil health, weather, season, and local farm conditions.',
            'image' => $images['featureCrop'],
            'image_alt' => 'Fresh seedling emerging from nutrient-rich soil',
            'position' => 'center center',
            'badge' => 'AI Powered',
            'bullets' => [
                'Analyzes soil nutrients and pH',
                'Considers climate, season and location',
                'Suggests high-yield suitable crops',
                'Helps in better crop planning',
            ],
        ],
        [
            'icon' => 'yield',
            'title' => 'Yield Prediction',
            'subtitle' => 'Production forecasting',
            'copy' => 'Predict yield accurately using AI models trained on crop, weather, field, and historical season data.',
            'image' => $images['featureYield'],
            'image_alt' => 'Open farmland with long productive crop rows under the sky',
            'position' => 'center center',
            'badge' => 'Live Forecast',
            'bullets' => [
                'AI and ML based prediction models',
                'Estimates yield in tons per hectare',
                'Improves planning and resource use',
                'Reduces uncertainty in farming',
            ],
        ],
        [
            'icon' => 'disease',
            'title' => 'Disease Detection',
            'subtitle' => 'Leaf scan intelligence',
            'copy' => 'Detect crop diseases early using image analysis so farmers can respond before damage spreads.',
            'image' => $images['featureDisease'],
            'image_alt' => 'Close-up of a diseased leaf with visible stress marks',
            'position' => 'center center',
            'badge' => 'Image Recognition',
            'bullets' => [
                'Image recognition technology',
                'Identifies disease and severity',
                'Suggests treatment and precautions',
                'Protects crops before spreading',
            ],
        ],
        [
            'icon' => 'fertilizer',
            'title' => 'Fertilizer Recommendation',
            'subtitle' => 'Balanced soil nutrition',
            'copy' => 'Get smart fertilizer suggestions based on soil nutrients and crop stage to improve soil health.',
            'image' => $images['featureFertilizer'],
            'image_alt' => 'Young plant growing from a soil-filled bag',
            'position' => 'center center',
            'badge' => 'NPK Planner',
            'bullets' => [
                'Analyzes NPK and micronutrients',
                'Recommends type and quantity',
                'Promotes balanced soil nutrition',
                'Reduces fertilizer waste and cost',
            ],
        ],
        [
            'icon' => 'weather',
            'title' => 'Weather Forecast',
            'subtitle' => 'Field-ready alerts',
            'copy' => 'Stay ahead with accurate location-based weather updates for irrigation, spraying, and harvesting.',
            'image' => $images['featureWeather'],
            'image_alt' => 'Wide green farmland under dramatic weather clouds',
            'position' => 'center center',
            'badge' => '7-Day Outlook',
            'bullets' => [
                'Real-time weather updates',
                'Rainfall, temperature and humidity',
                'Severe weather alerts',
                'Helps in timely decision making',
            ],
        ],
        [
            'icon' => 'dashboard',
            'title' => 'Real-time Dashboard',
            'subtitle' => 'Farm insights in one view',
            'copy' => 'Monitor farm data, alerts, crop performance, and recommendations from one clean dashboard.',
            'image' => $images['featureDashboard'],
            'image_alt' => 'Agronomist and farmer reviewing farm data on a tablet in the field',
            'position' => 'center center',
            'badge' => 'Live Analytics',
            'bullets' => [
                'Live farm data and analytics',
                'Interactive charts and reports',
                'Alerts and notifications',
                'Better visibility and control',
            ],
        ],
    ];

    $featureHeroPills = [
        'AI Powered',
        'Real-time Data',
        'Smart Insights',
        'Farmer First',
    ];

    $featureHeroMetrics = [
        ['label' => 'Crop Health', 'value' => '92%', 'detail' => 'Excellent', 'icon' => 'crop'],
        ['label' => 'Weather', 'value' => '28 C', 'detail' => 'Partly Cloudy', 'icon' => 'weather'],
        ['label' => 'Yield Prediction', 'value' => '4.2', 'detail' => 'ton/ha', 'icon' => 'yield'],
        ['label' => 'Soil Status', 'value' => 'Good', 'detail' => 'pH 6.7', 'icon' => 'soil'],
    ];

    $steps = [
        [
            'icon' => 'account',
            'title' => 'Collect Farm Data',
            'copy' => 'Soil, weather, crop, and field data is collected through inputs and sensors.',
        ],
        [
            'icon' => 'details',
            'title' => 'AI & Data Analysis',
            'copy' => 'Advanced AI models analyse the data and detect patterns for accurate insights.',
        ],
        [
            'icon' => 'analysis',
            'title' => 'Smart Suggestions',
            'copy' => 'AgroVision generates crop, fertilizer, disease, and weather-based recommendations.',
        ],
        [
            'icon' => 'result',
            'title' => 'Better Decisions',
            'copy' => 'Make confident, data-driven decisions and improve productivity all season.',
        ],
    ];

    $benefits = [
        ['icon' => 'productivity', 'label' => 'Increase Productivity'],
        ['icon' => 'waste', 'label' => 'Reduce Fertilizer Waste'],
        ['icon' => 'early', 'label' => 'Early Disease Alerts'],
        ['icon' => 'yield', 'label' => 'Accurate Yield Planning'],
        ['icon' => 'data', 'label' => 'Weather-based Decisions'],
        ['icon' => 'time', 'label' => 'Easy & Farmer-Friendly Interface'],
    ];

    $featureTechStack = [
        [
            'title' => 'Frontend',
            'copy' => 'HTML, CSS, JavaScript and modern UI patterns for a smooth farmer-friendly experience.',
            'icon' => 'code',
        ],
        [
            'title' => 'Backend',
            'copy' => 'Laravel-powered services handling secure workflows, business logic, and scalable APIs.',
            'icon' => 'server',
        ],
        [
            'title' => 'Database',
            'copy' => 'MySQL stores crop history, field records, weather context, and recommendation data fast.',
            'icon' => 'database',
        ],
        [
            'title' => 'AI / ML',
            'copy' => 'Machine learning models drive yield prediction, disease detection, and smart suggestions.',
            'icon' => 'brain',
        ],
        [
            'title' => 'APIs',
            'copy' => 'Weather and agronomy integrations keep real-time external signals flowing into AgroVision.',
            'icon' => 'api',
        ],
    ];

    $heroStats = [
        ['title' => 'AI Powered', 'copy' => 'Recommendations you can trust', 'icon' => 'support'],
        ['title' => 'Live Analytics', 'copy' => 'Actionable farm insights', 'icon' => 'clock'],
        ['title' => 'Farmer Friendly', 'copy' => 'Built for quick decisions', 'icon' => 'trust'],
    ];

    $footerLinks = [
        ['label' => 'Home', 'href' => route('home')],
        ['label' => 'About Us', 'href' => route('about')],
        ['label' => 'Features', 'href' => route('features')],
    ];

    if ($dashboardUrl) {
        $footerLinks[] = ['label' => 'Dashboard', 'href' => $dashboardUrl];
    }

    $footerLinks[] = ['label' => 'Contact Us', 'href' => route('contact')];

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $brandName }} Features | Smart Farming Tools</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
    </head>
    <body class="home-body contact-page-body" data-page="features">
        <div id="top"></div>

        <div class="site-topbar contact-topbar">
            <div class="site-container site-topbar__inner">
                <div class="site-topbar__group">
                    <a class="site-topbar__link" href="{{ route('contact') }}">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 3.5c-3.1 0-5.5 2.4-5.5 5.4 0 4.2 5.5 11.6 5.5 11.6s5.5-7.4 5.5-11.6c0-3-2.4-5.4-5.5-5.4Zm0 7.5a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span>AgroVision Smart Farming Project, Himachal Pradesh</span>
                    </a>
                    <a class="site-topbar__link" href="tel:+917018741392">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m6.8 4.9 2.4-.7a1.3 1.3 0 0 1 1.5.7l1.1 2.7a1.3 1.3 0 0 1-.3 1.4l-1.3 1.3a13.9 13.9 0 0 0 3.5 3.5l1.3-1.3a1.3 1.3 0 0 1 1.4-.3l2.7 1.1a1.3 1.3 0 0 1 .7 1.5l-.7 2.4a1.3 1.3 0 0 1-1.3 1C11.2 19.5 4.5 12.8 4.5 6.2a1.3 1.3 0 0 1 1-1.3Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>+91 70187 41392</span>
                    </a>
                    <a class="site-topbar__link" href="mailto:hello@agrovision.com">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4.5 6.5h15v11h-15z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                <path d="m5.6 7.4 6.4 5 6.4-5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>hello@agrovision.com</span>
                    </a>
                </div>

                <div class="site-topbar__group site-topbar__group--right">
                    <button class="site-topbar__lang" type="button">
                        <span>English</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m7 10 5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="site-socials" aria-label="Social links">
                        <a href="{{ route('contact') }}" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="LinkedIn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 8.5a3 3 0 0 0-2.1-2.1C17 6 12 6 12 6s-5 0-6.9.4A3 3 0 0 0 3 8.5 31.7 31.7 0 0 0 2.6 12 31.7 31.7 0 0 0 3 15.5a3 3 0 0 0 2.1 2.1C7 18 12 18 12 18s5 0 6.9-.4a3 3 0 0 0 2.1-2.1c.3-1.1.4-2.3.4-3.5s-.1-2.4-.4-3.5ZM10 15V9l5 3-5 3Z" fill="currentColor"/></svg></a>
                    </div>
                </div>
            </div>
        </div>

        <header class="site-header contact-header" data-header>
            <div class="site-container site-header__inner">
                <a class="site-brand" href="{{ route('home') }}">
                    <span class="site-brand__mark">
                        <svg viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                            <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/>
                            <path d="M31.2 12.3c1.5 7.1-1.6 14.6-8 19.2-3.8 2.8-8.5 4.3-13.2 4.2 4.6 2.7 10.9 3 16.4.9 5.4-2.1 10.3-6.9 12.5-12.2 2.1-5 1.4-10-1.7-13.1-1.8-1.7-3.9-2.7-6-3Z" fill="#8edb57" opacity=".72"/>
                        </svg>
                    </span>
                    <span class="site-brand__copy">
                        <strong>{{ $brandName }}</strong>
                        <small>Smart Farming, Better Future</small>
                    </span>
                </a>

                <button class="site-nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="site-header__menu" id="site-nav" data-nav-panel>
                    <nav class="site-nav" aria-label="Primary">
                        <a class="site-nav__link" href="{{ route('home') }}">Home</a>
                        <a class="site-nav__link" href="{{ route('about') }}">About</a>
                        <a class="site-nav__link is-active" href="{{ route('features') }}">Features</a>
                        @auth
                            <a class="site-nav__link" href="{{ route('dashboard') }}">Dashboard</a>
                        @endauth
                        @include('partials.services-dropdown', ['serviceLinks' => $serviceLinks])
                        <a class="site-nav__link" href="{{ route('contact') }}">Contact</a>
                    </nav>

                    <div class="site-header__actions">
                        @include('partials.public-auth-actions')
                    </div>
                </div>
            </div>
        </header>

        <main class="contact-main">
            <section class="contact-hero" data-section="features">
                <div class="contact-hero__media" aria-hidden="true">
                    <img src="{{ $images['hero'] }}" alt="Farmer using a tablet in a crop field" loading="eager">
                </div>
                <div class="contact-hero__overlay"></div>
                <div class="site-container contact-hero__inner">
                    <div class="contact-hero__copy" data-reveal>
                        <h1>Powerful Features for <span>Smarter Farming</span></h1>
                        <p>
                            Explore the complete AgroVision feature suite built to help farmers plan crops,
                            predict yield, detect disease early, optimize fertilizers, and act faster with live data.
                        </p>

                        <div class="contact-hero__stats">
                            @foreach ($heroStats as $stat)
                                <article class="contact-hero__stat">
                                    <span class="contact-icon contact-icon--soft">
                                        @if ($stat['icon'] === 'support')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 13a7 7 0 0 1 14 0v3a2 2 0 0 1-2 2h-2M5 13v3a2 2 0 0 0 2 2h1M9 18h6M9 10a3 3 0 0 1 6 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @elseif ($stat['icon'] === 'clock')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7v5l3 3M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.8 18 6v5.5c0 4-2.5 7.3-6 8.7-3.5-1.4-6-4.7-6-8.7V6l6-2.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="m9 12 2 2 4-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @endif
                                    </span>
                                    <div>
                                        <strong>{{ $stat['title'] }}</strong>
                                        <small>{{ $stat['copy'] }}</small>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    <div class="contact-hero__mark" aria-hidden="true">
                        <span class="site-brand__mark">
                            <svg viewBox="0 0 48 48"><path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/><path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/></svg>
                        </span>
                    </div>
                </div>
            </section>

            <section class="home-feature-hub" id="feature-suite" data-section="feature-suite">
                <div class="site-container">
                    <div class="home-feature-hub__shell">
                        <div class="section-heading home-section-heading home-feature-hub__heading" data-reveal>
                            <span class="section-chip section-chip--soft">Features</span>
                            <h2>Everything you need for a smarter farm operation</h2>
                            <p>
                                AgroVision brings advanced technology to your fields with AI-powered recommendations,
                                yield forecasting, disease detection, weather planning, and live farm insights.
                            </p>
                            <div class="section-divider"></div>
                        </div>

                        <div class="home-feature-hub__hero" data-reveal>
                            <div class="home-feature-hub__hero-copy">
                                <span class="home-feature-hub__eyebrow">Smart Farming Feature Suite</span>
                                <h3>Everything your farm needs in one intelligent workspace.</h3>
                                <p>
                                    From crop recommendation to real-time insights, AgroVision helps farmers grow
                                    better, protect crops early, and make confident decisions with clean visual data.
                                </p>

                                <div class="home-feature-hub__pills">
                                    @foreach ($featureHeroPills as $pill)
                                        <span>{{ $pill }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="home-feature-hub__hero-media">
                                <img src="{{ $images['hero'] }}" alt="Farmer using a tablet while examining crops in the field" loading="lazy">
                                <div class="home-feature-hub__hero-overlay" aria-hidden="true"></div>

                                <div class="home-feature-hub__hero-metrics">
                                    @foreach ($featureHeroMetrics as $metric)
                                        <article class="home-feature-hub__metric-card">
                                            <span class="home-feature-hub__metric-icon">
                                                @if ($metric['icon'] === 'crop')
                                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                                @elseif ($metric['icon'] === 'weather')
                                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 4.5v2.4M21 7.2h-2.4M15 7.2h-2.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                                @elseif ($metric['icon'] === 'yield')
                                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                                @else
                                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12.5h14M8 8.5h8M9 16.5h6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M12 4.5v15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" opacity=".4"/></svg>
                                                @endif
                                            </span>
                                            <p>{{ $metric['label'] }}</p>
                                            <strong>{{ $metric['value'] }}</strong>
                                            <small>{{ $metric['detail'] }}</small>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="home-feature-hub__spotlights" data-reveal>
                            @foreach ($featureCards as $feature)
                                <article class="home-feature-hub__spotlight">
                                    <span class="home-feature-hub__spotlight-icon">
                                        @if ($feature['icon'] === 'crop')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @elseif ($feature['icon'] === 'yield')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @elseif ($feature['icon'] === 'disease')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.5 17a6.5 6.5 0 1 1 4.6-11.1A6.5 6.5 0 0 1 10.5 17Zm4.8-1.1L20 20.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="m8.7 10.7 1.5 1.5 3.1-3.1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @elseif ($feature['icon'] === 'fertilizer')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 4h8v4h3v4c0 4-2.9 7.4-7 8-4.1-.6-7-4-7-8V8h3V4Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 9v6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @elseif ($feature['icon'] === 'weather')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 4.5v2.4M21 7.2h-2.4M15 7.2h-2.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 5.5h15v13h-15zM8 9h8M8 13h5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        @endif
                                    </span>
                                    <div>
                                        <strong>{{ $feature['title'] }}</strong>
                                        <small>{{ $feature['subtitle'] }}</small>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="home-feature-hub__details" id="services">
                            @foreach ($featureCards as $feature)
                                <article class="home-feature-detail" id="{{ \Illuminate\Support\Str::slug($feature['title']) }}" data-reveal>
                                    <div class="home-feature-detail__visual">
                                        <img src="{{ $feature['image'] }}" alt="{{ $feature['image_alt'] }}" loading="lazy">
                                        <span class="home-feature-detail__badge">{{ $feature['badge'] }}</span>
                                    </div>

                                    <div class="home-feature-detail__copy">
                                        <span class="home-feature-detail__icon">
                                            @if ($feature['icon'] === 'crop')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($feature['icon'] === 'yield')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($feature['icon'] === 'disease')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.5 17a6.5 6.5 0 1 1 4.6-11.1A6.5 6.5 0 0 1 10.5 17Zm4.8-1.1L20 20.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="m8.7 10.7 1.5 1.5 3.1-3.1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($feature['icon'] === 'fertilizer')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 4h8v4h3v4c0 4-2.9 7.4-7 8-4.1-.6-7-4-7-8V8h3V4Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 9v6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($feature['icon'] === 'weather')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 4.5v2.4M21 7.2h-2.4M15 7.2h-2.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @else
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 5.5h15v13h-15zM8 9h8M8 13h5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @endif
                                        </span>

                                        <div>
                                            <small>{{ $feature['subtitle'] }}</small>
                                            <h3>{{ $feature['title'] }}</h3>
                                        </div>

                                        <p>{{ $feature['copy'] }}</p>
                                    </div>

                                    <ul class="home-feature-detail__points">
                                        @foreach ($feature['bullets'] as $point)
                                            <li>
                                                <span>
                                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 12.4 4 4 8-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                                <p>{{ $point }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </article>
                            @endforeach
                        </div>

                        <div class="home-feature-hub__workflow" data-reveal>
                            <div class="section-heading home-section-heading home-section-heading--tight">
                                <span class="section-chip section-chip--soft">How AgroVision Works</span>
                                <h2>Clear steps from data to better decisions.</h2>
                            </div>

                            <div class="home-feature-hub__workflow-grid">
                                @foreach ($steps as $index => $step)
                                    <article class="home-feature-hub__workflow-step">
                                        <span class="home-feature-hub__workflow-icon">
                                            @if ($step['icon'] === 'account')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 17.5c1.8-4.4 4.1-7.2 7-8.6 2.8 1.4 5.1 4.2 7 8.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M12 5.3a2.9 2.9 0 1 1 0 5.8 2.9 2.9 0 0 1 0-5.8Z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>
                                            @elseif ($step['icon'] === 'details')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 5.5h12v13H6zM9 9h6M9 13h4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @elseif ($step['icon'] === 'analysis')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 3v4M15 3v4M9 17v4M15 17v4M3 9h4M3 15h4M17 9h4M17 15h4M8 8h8v8H8z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @else
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @endif
                                        </span>
                                        <strong>{{ $index + 1 }}. {{ $step['title'] }}</strong>
                                        <p>{{ $step['copy'] }}</p>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <div class="home-feature-hub__benefits" data-reveal>
                            <div class="section-heading home-section-heading home-section-heading--tight">
                                <span class="section-chip section-chip--soft">Benefits</span>
                                <h2>Benefits you get with AgroVision.</h2>
                            </div>

                            <div class="home-feature-hub__benefit-strip">
                                @foreach ($benefits as $benefit)
                                    <article class="home-feature-hub__benefit">
                                        <span class="home-feature-hub__benefit-icon">
                                            @if ($benefit['icon'] === 'productivity')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($benefit['icon'] === 'waste')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 4h8v4h3v4c0 4-2.9 7.4-7 8-4.1-.6-7-4-7-8V8h3V4Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 9v6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($benefit['icon'] === 'early')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.5 17a6.5 6.5 0 1 1 4.6-11.1A6.5 6.5 0 0 1 10.5 17Zm4.8-1.1L20 20.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="m8.7 10.7 1.5 1.5 3.1-3.1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($benefit['icon'] === 'yield')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @elseif ($benefit['icon'] === 'data')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 4.5v2.4M21 7.2h-2.4M15 7.2h-2.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @else
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 5.5h15v13h-15zM8 9h8M8 13h5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @endif
                                        </span>
                                        <p>{{ $benefit['label'] }}</p>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <div class="home-feature-hub__tech" data-reveal>
                            <div class="section-heading home-section-heading home-section-heading--tight">
                                <span class="section-chip section-chip--soft">Technology</span>
                                <h2>Technology behind AgroVision.</h2>
                            </div>

                            <div class="home-feature-hub__tech-grid">
                                @foreach ($featureTechStack as $stack)
                                    <article class="home-feature-hub__tech-card">
                                        <span class="home-feature-hub__tech-icon">
                                            @if ($stack['icon'] === 'code')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M13.5 5 10.5 19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @elseif ($stack['icon'] === 'server')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4.5" width="16" height="6" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><rect x="4" y="13.5" width="16" height="6" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M8 7.5h.01M8 16.5h.01" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                                            @elseif ($stack['icon'] === 'database')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><ellipse cx="12" cy="6.5" rx="6.5" ry="2.8" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M5.5 6.5v10c0 1.5 2.9 2.8 6.5 2.8s6.5-1.3 6.5-2.8v-10" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M5.5 11.5c0 1.5 2.9 2.8 6.5 2.8s6.5-1.3 6.5-2.8" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>
                                            @elseif ($stack['icon'] === 'brain')
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6.2a3 3 0 0 1 6 0 2.8 2.8 0 0 1 2.9 2.9 2.8 2.8 0 0 1-.7 1.9 3 3 0 0 1-.8 5.9H8.6A3 3 0 0 1 7.8 11a2.8 2.8 0 0 1-.7-1.9A2.8 2.8 0 0 1 10 6.2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6.2v10.6M9.6 10.2H12M12 13.7h2.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @else
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="6" width="16" height="12" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M8 12h8M12 9v6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            @endif
                                        </span>
                                        <h3>{{ $stack['title'] }}</h3>
                                        <p>{{ $stack['copy'] }}</p>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <div class="home-feature-hub__cta" data-reveal>
                            <div class="home-feature-hub__cta-bg" aria-hidden="true">
                                <img src="{{ $images['featureConsult'] }}" alt="" loading="lazy">
                            </div>

                            <span class="home-feature-hub__cta-mark">
                                <svg viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                    <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#d4ff8a"/>
                                </svg>
                            </span>

                            <div class="home-feature-hub__cta-copy">
                                <h2>Ready to explore AgroVision features?</h2>
                                <p>
                                    Discover how smart recommendations, real-time insights, and clean dashboards can
                                    transform your farming decisions this season.
                                </p>
                            </div>

                            <div class="home-feature-hub__cta-actions">
                                <a class="site-button site-button--light" href="{{ auth()->check() ? route('dashboard') : route('register') }}">
                                    <span>{{ auth()->check() ? 'Open Dashboard' : 'Get Started' }}</span>
                                </a>
                                <a class="site-button site-button--ghost" href="{{ route('contact') }}">
                                    <span>Contact Us</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="agro-long-section agro-long-section--alt">
                <div class="site-container">
                    <div class="agro-long-section__header" data-reveal>
                        <span class="section-chip section-chip--soft">Feature Depth</span>
                        <h2>Each tool explains the input, the processing logic, and the report clearly.</h2>
                        <p>AgroVision is built so farmers can understand what happened after every form submission. The platform does not hide results behind confusing technical terms.</p>
                    </div>

                    <div class="agro-long-grid" data-reveal>
                        <article class="agro-long-card">
                            <strong>Input clarity</strong>
                            <p>Every form asks only for the data needed by that feature. Crop recommendation focuses on soil, weather, nutrients and season. Yield prediction focuses on crop, area, irrigation, soil and climate. Disease detection focuses on image and visible symptoms.</p>
                        </article>
                        <article class="agro-long-card">
                            <strong>Result clarity</strong>
                            <p>Each result page shows the output in farmer-friendly language: recommended crop, expected yield, disease name, treatment, fertilizer, dosage, weather condition, or saved soil status.</p>
                        </article>
                        <article class="agro-long-card">
                            <strong>Admin clarity</strong>
                            <p>The admin panel shows both user input and final result. This makes it easier to check user activity, review farming decisions, and understand how each report was created.</p>
                        </article>
                    </div>

                    <div class="agro-long-timeline" data-reveal>
                        <article class="agro-long-step">
                            <span>A</span>
                            <div>
                                <h3>Google APIs support location and weather only</h3>
                                <p>Maps JavaScript, Places, Geocoding, and Weather APIs help with location autocomplete, coordinates, and live climate data. They do not decide soil type, disease, fertilizer, yield, or reports.</p>
                            </div>
                        </article>
                        <article class="agro-long-step">
                            <span>B</span>
                            <div>
                                <h3>Database logic powers reports and recommendations</h3>
                                <p>Farm reports, fertilizer rules, saved soil profiles, and user history come from your own MySQL database, making records private, searchable, and secure.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer site-footer--contact" id="contact">
            <div class="site-container site-footer__main contact-footer__main">
                <div class="site-footer__brand">
                    <a class="site-brand site-brand--footer" href="{{ route('home') }}">
                        <span class="site-brand__mark">
                            <svg viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/>
                            </svg>
                        </span>
                        <span class="site-brand__copy">
                            <strong>{{ $brandName }}</strong>
                            <small>Smart Farming, Better Future</small>
                        </span>
                    </a>

                    <p class="site-footer__brand-copy">
                        Explore the full AgroVision feature suite built to support better planning, healthier crops,
                        and faster farm decisions.
                    </p>

                    <div class="site-socials site-socials--footer">
                        <a href="{{ route('contact') }}" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="LinkedIn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/></svg></a>
                    </div>
                </div>

                <div class="site-footer__column">
                    <h3>Quick Links</h3>
                    <ul>
                        @foreach ($footerLinks as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="site-footer__column">
                    <h3>Our Services</h3>
                    <ul>
                        @foreach ($serviceLinks as $service)
                            <li><a href="{{ $service['href'] }}">{{ $service['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="site-footer__column">
                    <h3>Contact Us</h3>
                    <ul class="site-footer__contact">
                        <li>AgroVision Smart Farming Project, Himachal Pradesh, India</li>
                        <li><a href="tel:+917018741392">+91 70187 41392</a></li>
                        <li><a href="mailto:hello@agrovision.com">hello@agrovision.com</a></li>
                    </ul>
                </div>
            </div>

            <div class="site-footer__bottom">
                <div class="site-container site-footer__bottom-inner">
                    <p>&copy; {{ now()->year }} {{ $brandName }}. All rights reserved.</p>
                    <div>
                        <a href="{{ route('contact') }}">Privacy Policy</a>
                        <a href="{{ route('contact') }}">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>

        @include('partials.chat-widget')

        <a class="site-backtotop" href="#top" data-backtotop aria-label="Back to top">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m7 14 5-5 5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <script src="{{ asset('js/home-page.js') }}" defer></script>
        <script src="{{ asset('js/chat-widget.js') }}" defer></script>
    </body>
</html>
