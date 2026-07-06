@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }

    $currentUser = auth()->user();
    $dashboardUrl = $currentUser ? route('dashboard') : null;
    $profileName = $currentUser?->name;
    $profileEmail = $currentUser?->email;
    $profileInitial = $currentUser && filled($currentUser->name)
        ? strtoupper(substr($currentUser->name, 0, 1))
        : 'U';
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
        'hero' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'fieldRows' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'sunrise' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'sprout' => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'tabletFarmer' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'ctaLeaves' => 'https://images.unsplash.com/photo-1499529112087-3cb3b73cec95?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'droneField' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&fm=jpg&q=80&w=3000',
        'soilScan' => 'https://images.unsplash.com/photo-1516253593875-bd7ba052fbc0?auto=format&fit=crop&fm=jpg&q=80&w=3000',
    ];

    $heroHighlights = [
        ['label' => 'AI-Powered Insights', 'icon' => 'brain'],
        ['label' => 'Real-time Monitoring', 'icon' => 'pulse'],
        ['label' => 'Data-Driven Decisions', 'icon' => 'nodes'],
    ];

    $aboutHeroSlides = [
        [
            'eyebrow' => 'About AgroVision',
            'title' => 'Empowering Farmers',
            'highlight' => 'Through Smart Technology',
            'copy' => 'AgroVision is an AI-powered smart farming platform that helps farmers make better decisions with real-time crop monitoring, yield prediction, disease detection, fertilizer recommendations, and accurate weather insights.',
            'image' => $images['hero'],
            'tags' => $heroHighlights,
            'metrics' => [
                ['label' => 'Field Health', 'value' => 'Excellent'],
                ['label' => 'Soil Moisture', 'value' => '62%'],
                ['label' => 'Yield Prediction', 'value' => '4.2 ton/ha'],
            ],
            'dashboard' => [
                ['label' => 'Accuracy', 'value' => '98%'],
                ['label' => 'Alerts', 'value' => '2500+'],
            ],
        ],
        [
            'eyebrow' => 'Farmer-First Intelligence',
            'title' => 'Turning Farm Data',
            'highlight' => 'Into Clear Action',
            'copy' => 'From crop health scans to weather-aware decisions, AgroVision turns field signals into simple guidance that farmers can trust every day.',
            'image' => $images['droneField'],
            'tags' => [
                ['label' => 'Field Mapping', 'icon' => 'nodes'],
                ['label' => 'Smart Alerts', 'icon' => 'pulse'],
                ['label' => 'Crop Planning', 'icon' => 'brain'],
            ],
            'metrics' => [
                ['label' => 'Live Fields', 'value' => '2500+'],
                ['label' => 'Risk Alerts', 'value' => 'Low'],
                ['label' => 'Water Saving', 'value' => '18%'],
            ],
            'dashboard' => [
                ['label' => 'Coverage', 'value' => '94%'],
                ['label' => 'Reports', 'value' => '800+'],
            ],
        ],
        [
            'eyebrow' => 'Built For Better Harvests',
            'title' => 'Helping Every Acre',
            'highlight' => 'Grow Smarter',
            'copy' => 'Our platform supports better timing, healthier soil, and faster diagnosis so farms can reduce waste and improve productivity season after season.',
            'image' => $images['soilScan'],
            'tags' => [
                ['label' => 'Soil Insights', 'icon' => 'pulse'],
                ['label' => 'Disease Detection', 'icon' => 'brain'],
                ['label' => 'Yield Growth', 'icon' => 'nodes'],
            ],
            'metrics' => [
                ['label' => 'Crop Recovery', 'value' => '+25%'],
                ['label' => 'Soil Status', 'value' => 'Healthy'],
                ['label' => 'Harvest Plan', 'value' => 'Ready'],
            ],
            'dashboard' => [
                ['label' => 'Savings', 'value' => '22%'],
                ['label' => 'Forecast', 'value' => '7 days'],
            ],
        ],
    ];

    $stats = [
        ['value' => 1000, 'suffix' => '+', 'label' => 'Happy Farmers', 'icon' => 'users'],
        ['value' => 2500, 'suffix' => '+', 'label' => 'Fields Monitored', 'icon' => 'field'],
        ['value' => 98, 'suffix' => '%', 'label' => 'Prediction Accuracy', 'icon' => 'chart'],
        ['value' => 24, 'suffix' => '/7', 'label' => 'Support Availability', 'icon' => 'support'],
    ];

    $trustCards = [
        [
            'title' => 'AI-Powered Insights',
            'copy' => 'Advanced machine learning models provide accurate predictions and recommendations.',
            'icon' => 'brain',
        ],
        [
            'title' => 'Real-time Monitoring',
            'copy' => 'Monitor crops, soil, and weather conditions in real-time from anywhere.',
            'icon' => 'monitor',
        ],
        [
            'title' => 'Actionable Recommendations',
            'copy' => 'Get personalized advice on irrigation, fertilizers, and crop protection.',
            'icon' => 'clipboard',
        ],
        [
            'title' => 'Easy to Use',
            'copy' => 'Simple, intuitive platform designed for every farmer, on any device.',
            'icon' => 'phone',
        ],
        [
            'title' => 'Secure & Reliable',
            'copy' => 'Your data is safe with enterprise-grade security and privacy.',
            'icon' => 'shield',
        ],
        [
            'title' => 'Expert Support',
            'copy' => 'Our agronomy experts are here to help you every step of the way.',
            'icon' => 'headset',
        ],
    ];

    $steps = [
        [
            'number' => '1.',
            'title' => 'Collect Data',
            'copy' => 'We gather data from satellite, sensors, and weather APIs.',
            'icon' => 'target',
        ],
        [
            'number' => '2.',
            'title' => 'AI Analysis',
            'copy' => 'Our AI models analyze crop data to detect issues and predict outcomes.',
            'icon' => 'brain',
        ],
        [
            'number' => '3.',
            'title' => 'Smart Insights',
            'copy' => 'Get actionable insights and personalized recommendations.',
            'icon' => 'chart',
        ],
        [
            'number' => '4.',
            'title' => 'Better Decisions',
            'copy' => 'Make informed decisions to improve yield and increase profitability.',
            'icon' => 'plant',
        ],
    ];

    $team = [
        [
            'name' => 'Rahul Verma',
            'role' => 'CEO & Co-Founder',
            'copy' => 'Passionate about leveraging technology to empower farmers and transform agriculture.',
            'image' => 'https://randomuser.me/api/portraits/men/75.jpg',
        ],
        [
            'name' => 'Ananya Singh',
            'role' => 'CTO & Co-Founder',
            'copy' => 'AI researcher and tech innovator driving product vision and technology strategy.',
            'image' => 'https://randomuser.me/api/portraits/women/68.jpg',
        ],
        [
            'name' => 'Vikram Patel',
            'role' => 'Head of Agronomy',
            'copy' => 'Agriculture expert ensuring our solutions are practical, scientific, and farmer-friendly.',
            'image' => 'https://randomuser.me/api/portraits/men/52.jpg',
        ],
        [
            'name' => 'Meera Sharma',
            'role' => 'Head of Operations',
            'copy' => 'Operations leader ensuring seamless delivery and exceptional customer experience.',
            'image' => 'https://randomuser.me/api/portraits/women/65.jpg',
        ],
    ];

    $stories = [
        [
            'name' => 'Ramesh Yadav',
            'meta' => 'Wheat Farmer, Madhya Pradesh',
            'quote' => 'AgroVision helped me detect disease early and saved my crop. My yield increased by 25% this season.',
            'image' => 'https://randomuser.me/api/portraits/men/41.jpg',
        ],
        [
            'name' => 'Sita Devi',
            'meta' => 'Soybean Farmer, Maharashtra',
            'quote' => 'The fertilizer recommendations are spot on. I save money and get better results every time.',
            'image' => 'https://randomuser.me/api/portraits/women/49.jpg',
        ],
        [
            'name' => 'Mahesh Rao',
            'meta' => 'Cotton Farmer, Gujarat',
            'quote' => 'Weather alerts and irrigation advice are very helpful. Now I can plan ahead and avoid losses.',
            'image' => 'https://randomuser.me/api/portraits/men/57.jpg',
        ],
    ];

    $footerLinks = [
        ['label' => 'About Us', 'href' => route('about')],
        ['label' => 'Features', 'href' => route('features')],
    ];

    if ($dashboardUrl) {
        $footerLinks[] = ['label' => 'Dashboard', 'href' => $dashboardUrl];
    } else {
        $footerLinks[] = ['label' => 'Register', 'href' => route('register')];
    }

    $footerLinks[] = ['label' => 'Services', 'href' => route('services')];
    $footerLinks[] = ['label' => 'Contact Us', 'href' => route('contact')];

    $resources = ['User Guide', 'Blog', 'FAQs', 'Privacy Policy', 'Terms & Conditions'];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About {{ $brandName }} | Smart Farming Platform</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
    </head>
    <body class="home-body about-page-body" data-page="about">
        <div id="top"></div>

        <div class="site-topbar site-topbar--about">
            <div class="site-container site-topbar__inner">
                <div class="site-topbar__group">
                    <a class="site-topbar__link" href="#contact">
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
                        <a href="#contact" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="YouTube">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 8.5a3 3 0 0 0-2.1-2.1C17 6 12 6 12 6s-5 0-6.9.4A3 3 0 0 0 3 8.5 31.7 31.7 0 0 0 2.6 12 31.7 31.7 0 0 0 3 15.5a3 3 0 0 0 2.1 2.1C7 18 12 18 12 18s5 0 6.9-.4a3 3 0 0 0 2.1-2.1c.3-1.1.4-2.3.4-3.5s-.1-2.4-.4-3.5ZM10 15V9l5 3-5 3Z" fill="currentColor"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <header class="site-header" data-header>
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
                        <small>Smarter Insights, Better Future</small>
                    </span>
                </a>

                <button
                    class="site-nav-toggle"
                    type="button"
                    aria-expanded="false"
                    aria-controls="site-nav"
                    data-nav-toggle
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="site-header__menu" id="site-nav" data-nav-panel>
                    <nav class="site-nav" aria-label="Primary">
                        <a class="site-nav__link" href="{{ route('home') }}">Home</a>
                        <a class="site-nav__link is-active" href="{{ route('about') }}">About</a>
                        <a class="site-nav__link" href="{{ route('features') }}">Features</a>
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

        <main class="about-main about-redesign">
            <section class="about-redesign__hero" data-section="about">
                <div class="about-redesign__hero-slider" data-about-hero-slider data-parallax data-reveal>
                    @foreach ($aboutHeroSlides as $slide)
                        <article
                            class="about-redesign__hero-slide{{ $loop->first ? ' is-active' : '' }}"
                            data-about-hero-slide
                            aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                        >
                            <div class="about-redesign__hero-media" aria-hidden="true">
                                <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }} {{ $slide['highlight'] }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                            </div>
                            <div class="about-redesign__hero-overlay"></div>

                            <div class="site-container about-redesign__hero-content">
                                <div class="about-redesign__copy">
                                    <span class="section-chip">{{ $slide['eyebrow'] }}</span>
                                    <h1>
                                        <span class="about-redesign__headline-main">{{ $slide['title'] }}</span>
                                        <span class="about-redesign__headline-highlight">{{ $slide['highlight'] }}</span>
                                    </h1>
                                    <p>{{ $slide['copy'] }}</p>

                                    <div class="about-redesign__hero-tags">
                                        @foreach ($slide['tags'] as $highlight)
                                            <article class="about-redesign__tag">
                                                <span class="about-redesign__tag-icon">
                                                    @if ($highlight['icon'] === 'brain')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M9 4.5a3 3 0 0 0-3 3v1.1A2.9 2.9 0 0 0 4 11.5 2.9 2.9 0 0 0 6.5 14v1A3 3 0 0 0 9 18h1.5M15 4.5a3 3 0 0 1 3 3v1.1a2.9 2.9 0 0 1 2 2.9 2.9 2.9 0 0 1-2.5 2.5v1A3 3 0 0 1 15 18h-1.5M12 5v14M9 10h3M12 14h3" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                                        </svg>
                                                    @elseif ($highlight['icon'] === 'pulse')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M3 12h4l2.4-4.4L13 16l2.5-5H21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    @else
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M7 7h4v4H7zM13 13h4v4h-4zM13 7h4v4h-4zM7 13h4v4H7zM11 9h2M15 11v2M11 15h2M9 11v2" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                                        </svg>
                                                    @endif
                                                </span>
                                                <span>{{ $highlight['label'] }}</span>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="about-redesign__stage" aria-hidden="true">
                                    <div class="about-redesign__stage-metrics">
                                        @foreach ($slide['metrics'] as $metric)
                                            <article class="about-redesign__mini-card">
                                                <small>{{ $metric['label'] }}</small>
                                                <strong>{{ $metric['value'] }}</strong>
                                            </article>
                                        @endforeach
                                    </div>

                                    <article class="about-redesign__dashboard">
                                        <div class="about-redesign__dashboard-top">
                                            <span>AI Dashboard</span>
                                            <div class="about-redesign__dashboard-dots">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>

                                        <div class="about-redesign__dashboard-chart">
                                            <svg viewBox="0 0 340 120" aria-hidden="true">
                                                <path d="M10 74c18 4 28-24 44-28 19-5 24 26 44 23 20-3 20-36 40-39 24-4 24 28 43 30 20 2 28-16 49-22" fill="none" stroke="#3a9b49" stroke-width="4" stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        <div class="about-redesign__dashboard-grid">
                                            @foreach ($slide['dashboard'] as $item)
                                                <div class="about-redesign__dashboard-stat">
                                                    <span>{{ $item['label'] }}</span>
                                                    <strong>{{ $item['value'] }}</strong>
                                                </div>
                                            @endforeach
                                            <div class="about-redesign__dashboard-ring">
                                                <span></span>
                                            </div>
                                        </div>
                                    </article>

                                    <div class="about-redesign__drone">
                                        <svg viewBox="0 0 120 70">
                                            <path d="M38 30h44M60 18v28M48 32l-16 12M72 32l16 12M38 30 22 18M82 30l16-12" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                            <circle cx="18" cy="16" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                            <circle cx="102" cy="16" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                            <circle cx="18" cy="50" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                            <circle cx="102" cy="50" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                            <rect x="46" y="22" width="28" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    <div class="about-redesign__slider-controls" aria-label="About slider controls">
                        <button class="about-redesign__slider-arrow" type="button" data-about-hero-prev aria-label="Previous about slide">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m15 5-7 7 7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div class="about-redesign__slider-dots">
                            @foreach ($aboutHeroSlides as $slide)
                                <button
                                    class="about-redesign__slider-dot{{ $loop->first ? ' is-active' : '' }}"
                                    type="button"
                                    data-about-hero-dot
                                    data-about-hero-index="{{ $loop->index }}"
                                    aria-label="Go to about slide {{ $loop->iteration }}"
                                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                ></button>
                            @endforeach
                        </div>

                        <button class="about-redesign__slider-arrow" type="button" data-about-hero-next aria-label="Next about slide">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m9 5 7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <section class="about-redesign__mission">
                <div class="site-container">
                    <div class="about-redesign__mission-grid">
                        <article class="about-redesign__mission-card" data-reveal>
                            <div class="about-redesign__mission-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 5.5A6.5 6.5 0 1 1 5.5 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M12 8.5A3.5 3.5 0 1 1 8.5 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M12 12 20 4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <circle cx="20" cy="4" r="2" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="about-redesign__mission-copy">
                                <h2>Our Mission</h2>
                                <p>
                                    To empower every farmer with intelligent technology that simplifies farming,
                                    increases productivity, and builds a sustainable future.
                                </p>
                            </div>
                            <img src="{{ $images['sprout'] }}" alt="Young plant growing from soil" loading="lazy">
                        </article>

                        <article class="about-redesign__mission-card" data-reveal>
                            <div class="about-redesign__mission-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M2.5 12s3.6-6 9.5-6 9.5 6 9.5 6-3.6 6-9.5 6-9.5-6-9.5-6Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="2.8" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <div class="about-redesign__mission-copy">
                                <h2>Our Vision</h2>
                                <p>
                                    To be the world’s most trusted smart farming platform, driving innovation and
                                    transforming agriculture for generations to come.
                                </p>
                            </div>
                            <img src="{{ $images['sunrise'] }}" alt="Sunrise over cultivated farmland" loading="lazy">
                        </article>
                    </div>
                </div>
            </section>

            <section class="about-redesign__story">
                <div class="site-container">
                    <div class="about-redesign__story-grid">
                        <div class="about-redesign__story-media" data-reveal>
                            <img src="{{ $images['fieldRows'] }}" alt="Agricultural field rows" loading="lazy">
                            <div class="about-redesign__story-drone" aria-hidden="true">
                                <svg viewBox="0 0 120 70">
                                    <path d="M38 30h44M60 18v28M48 32l-16 12M72 32l16 12M38 30 22 18M82 30l16-12" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                    <circle cx="18" cy="16" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                    <circle cx="102" cy="16" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                    <circle cx="18" cy="50" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                    <circle cx="102" cy="50" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
                                    <rect x="46" y="22" width="28" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="3"/>
                                </svg>
                            </div>
                            <div class="about-redesign__story-tablet">
                                <img src="{{ $images['tabletFarmer'] }}" alt="Farmer with tablet outdoors" loading="lazy">
                            </div>
                        </div>

                        <div class="about-redesign__story-copy" data-reveal>
                            <span class="about-redesign__eyebrow">Our Story</span>
                            <h2>Building the Future of Farming</h2>
                            <p>
                                AgroVision was founded with a simple belief: technology can transform the way farming
                                is done. We saw the challenges farmers face every day, unpredictable weather, crop
                                diseases, low yields, and lack of timely insights.
                            </p>
                            <p>
                                So, we built AgroVision, an AI-powered platform that brings together satellite imagery,
                                IoT sensors, machine learning, and agronomic expertise to deliver real-time, actionable
                                insights in the farmer’s hands.
                            </p>
                            <p>
                                Today, AgroVision is trusted by thousands of farmers across the country to monitor their
                                crops, improve productivity, and grow a better tomorrow.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="about-redesign__stats">
                <div class="site-container">
                    <div class="about-redesign__stats-band" data-reveal>
                        @foreach ($stats as $stat)
                            <article class="about-redesign__stat">
                                <span class="about-redesign__stat-icon">
                                    @if ($stat['icon'] === 'users')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M9 11a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm6 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3ZM4 19c0-2.2 2.3-4 5-4s5 1.8 5 4M11 19c0-1.9 2-3.4 4.5-3.4S20 17.1 20 19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($stat['icon'] === 'field')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                            <path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($stat['icon'] === 'chart')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4 13a8 8 0 0 1 16 0v1a2 2 0 0 1-2 2h-1v-4M6 12v4H5a2 2 0 0 1-2-2v-1M12 19a3 3 0 0 0 3-3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </span>
                                <strong><span data-count="{{ $stat['value'] }}">0</span>{{ $stat['suffix'] }}</strong>
                                <p>{{ $stat['label'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="about-redesign__trust" id="trust" data-section="trust">
                <div class="site-container">
                    <div class="section-heading about-redesign__heading" data-reveal>
                        <span class="about-redesign__eyebrow">Why Farmers Trust Us</span>
                        <h2>Why Choose AgroVision?</h2>
                    </div>

                    <div class="about-redesign__trust-grid">
                        @foreach ($trustCards as $card)
                            <article class="about-redesign__trust-card" data-reveal>
                                <span class="about-redesign__trust-icon">
                                    @if ($card['icon'] === 'brain')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M9 4.5a3 3 0 0 0-3 3v1.1A2.9 2.9 0 0 0 4 11.5 2.9 2.9 0 0 0 6.5 14v1A3 3 0 0 0 9 18h1.5M15 4.5a3 3 0 0 1 3 3v1.1a2.9 2.9 0 0 1 2 2.9 2.9 2.9 0 0 1-2.5 2.5v1A3 3 0 0 1 15 18h-1.5M12 5v14M9 10h3M12 14h3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($card['icon'] === 'monitor')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4.5 5.5h15v10.5h-15zM9 20h6M12 16v4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @elseif ($card['icon'] === 'clipboard')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M6 4.5h12v15H6zM9 9h6M9 13h6M9 17h4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9 4h6v3H9z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                        </svg>
                                    @elseif ($card['icon'] === 'phone')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M9 3.5h6a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2ZM11 17.5h2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($card['icon'] === 'shield')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 3.8 18 6v5.5c0 4-2.5 7.3-6 8.7-3.5-1.4-6-4.7-6-8.7V6l6-2.2Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                            <path d="m9.5 12.2 1.7 1.8 3.5-3.7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4 13a8 8 0 0 1 16 0v1a2 2 0 0 1-2 2h-1v-4M6 12v4H5a2 2 0 0 1-2-2v-1M12 19a3 3 0 0 0 3-3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </span>
                                <h3>{{ $card['title'] }}</h3>
                                <p>{{ $card['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="about-redesign__process" id="services" data-section="services">
                <div class="site-container">
                    <div class="about-redesign__process-grid">
                        <div class="about-redesign__process-copy" data-reveal>
                            <span class="about-redesign__eyebrow">How AgroVision Works</span>
                            <h2>Smart Technology, Simple Steps</h2>

                            <div class="about-redesign__steps">
                                @foreach ($steps as $index => $step)
                                    <article class="about-redesign__step">
                                        <span class="about-redesign__step-icon">
                                            @if ($step['icon'] === 'target')
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M12 5.2a6.8 6.8 0 1 0 6.8 6.8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                    <path d="M12 9.4a2.6 2.6 0 1 0 2.6 2.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                    <path d="M12 12 20 4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                    <circle cx="20" cy="4" r="1.9" fill="currentColor"/>
                                                </svg>
                                            @elseif ($step['icon'] === 'brain')
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M9 4.5a3 3 0 0 0-3 3v1.1A2.9 2.9 0 0 0 4 11.5 2.9 2.9 0 0 0 6.5 14v1A3 3 0 0 0 9 18h1.5M15 4.5a3 3 0 0 1 3 3v1.1a2.9 2.9 0 0 1 2 2.9 2.9 2.9 0 0 1-2.5 2.5v1A3 3 0 0 1 15 18h-1.5M12 5v14M9 10h3M12 14h3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                </svg>
                                            @elseif ($step['icon'] === 'chart')
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                </svg>
                                            @else
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                                    <path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                </svg>
                                            @endif
                                        </span>
                                        <h3>{{ $step['number'] }} {{ $step['title'] }}</h3>
                                        <p>{{ $step['copy'] }}</p>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <div class="about-redesign__analysis" data-reveal>
                            <img src="{{ $images['fieldRows'] }}" alt="Smart farming analysis field" loading="lazy">
                            <article class="about-redesign__analysis-panel">
                                <strong>AI Analysis Complete</strong>
                                <small>Duration 90%</small>
                                <ul>
                                    <li>No Disease Detected</li>
                                    <li>Irrigation Optimal</li>
                                    <li>Fertilization Recommended</li>
                                </ul>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="about-redesign__team" id="team">
                <div class="site-container">
                    <div class="section-heading about-redesign__heading about-redesign__heading--left" data-reveal>
                        <span class="about-redesign__eyebrow">Meet Our Team</span>
                        <h2>The Minds Behind AgroVision</h2>
                    </div>

                    <div class="about-redesign__team-grid">
                        @foreach ($team as $member)
                            <article class="about-redesign__team-card" data-reveal>
                                <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" loading="lazy">
                                <div>
                                    <h3>{{ $member['name'] }}</h3>
                                    <small>{{ $member['role'] }}</small>
                                    <p>{{ $member['copy'] }}</p>
                                </div>
                                <a class="about-redesign__team-link" href="#contact" aria-label="Open profile for {{ $member['name'] }}">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/>
                                    </svg>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="about-redesign__stories">
                <div class="site-container">
                    <div class="section-heading about-redesign__heading about-redesign__heading--left" data-reveal>
                        <span class="about-redesign__eyebrow">Farmer Success Stories</span>
                        <h2>Real Farmers. Real Impact.</h2>
                    </div>

                    <div class="about-redesign__stories-grid">
                        @foreach ($stories as $story)
                            <article class="about-redesign__story-card" data-reveal>
                                <img src="{{ $story['image'] }}" alt="{{ $story['name'] }}" loading="lazy">
                                <div>
                                    <div class="about-redesign__stars" aria-hidden="true">★★★★★</div>
                                    <p>{{ $story['quote'] }}</p>
                                    <strong>{{ $story['name'] }}</strong>
                                    <small>{{ $story['meta'] }}</small>
                                </div>
                            </article>
                        @endforeach

                        <article class="about-redesign__join-card" data-reveal>
                            <div>
                                <h3>Join Thousands of Farmers Growing Smarter with AgroVision.</h3>
                            </div>
                            <img src="{{ $images['ctaLeaves'] }}" alt="Fresh green leaves" loading="lazy">
                        </article>
                    </div>
                </div>
            </section>

            <section class="agro-long-section">
                <div class="site-container">
                    <div class="agro-long-section__header" data-reveal>
                        <span class="section-chip section-chip--soft">Our Approach</span>
                        <h2>AgroVision is not just a dashboard, it is a farm decision support system.</h2>
                        <p>The platform is designed to make farm data understandable. It separates what should come from APIs, what should come from the farmer, and what should come from AgroVision’s own database logic.</p>
                    </div>

                    <div class="agro-long-timeline" data-reveal>
                        <article class="agro-long-step">
                            <span>01</span>
                            <div>
                                <h3>Collect practical farm information</h3>
                                <p>Farmers provide crop name, soil type, land area, symptoms, nutrients, growth stage, irrigation type, and location. The system keeps forms simple while still collecting enough context for useful recommendations.</p>
                            </div>
                        </article>
                        <article class="agro-long-step">
                            <span>02</span>
                            <div>
                                <h3>Use APIs only where they are reliable</h3>
                                <p>Google Places, Geocoding, and Weather are used for location and climate context. Soil type, disease image analysis, fertilizer rules, yield formulas, and farm reports remain inside AgroVision logic or future ML modules.</p>
                            </div>
                        </article>
                        <article class="agro-long-step">
                            <span>03</span>
                            <div>
                                <h3>Save every result for review</h3>
                                <p>Every crop recommendation, yield prediction, disease detection, fertilizer suggestion, weather search, and soil profile is saved securely so farmers and admins can review the exact input and output later.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="about-redesign__cta">
                <div class="site-container">
                    <div class="about-redesign__cta-shell" data-reveal>
                        <div class="about-redesign__cta-bg">
                            <img src="{{ $images['ctaLeaves'] }}" alt="Plants on dark soil" loading="lazy">
                        </div>
                        <div class="about-redesign__cta-copy">
                            <h2>Ready to Transform Your Farming?</h2>
                            <p>Join AgroVision today and take the power of AI-driven farming in your hands.</p>
                        </div>
                        <div class="about-redesign__cta-actions">
                            <a class="site-button site-button--light" href="{{ route('register') }}">Get Started Now</a>
                            <a class="site-button site-button--ghost-light" href="#contact" data-nav-link>Talk to Our Expert</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer site-footer--about" id="contact" data-section="contact">
            <div class="site-container site-footer__main site-footer__main--about-redesign">
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
                            <small>Empowering farmers with AI-driven insights, real-time monitoring, and smart recommendations for a better tomorrow.</small>
                        </span>
                    </a>

                    <div class="site-socials site-socials--footer">
                        <a href="#contact" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/>
                            </svg>
                        </a>
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
                    <h3>Resources</h3>
                    <ul>
                        @foreach ($resources as $resource)
                            <li><a href="#contact">{{ $resource }}</a></li>
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
                <div class="site-container site-footer__bottom-inner site-footer__bottom-inner--about-redesign">
                    <p>&copy; {{ now()->year }} {{ $brandName }}. All rights reserved.</p>
                    <p>Made with care for farmers worldwide.</p>
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
