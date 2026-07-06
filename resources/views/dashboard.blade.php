@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }

    $user = auth()->user();
    $userName = $user?->name ?: 'Rahul Kumar';
    $userInitial = strtoupper(substr($userName, 0, 1));
    $today = now()->format('d F Y');

    $sidebarGroups = [
        [
            'items' => [
                ['label' => 'Dashboard', 'icon' => 'dashboard', 'active' => true, 'href' => route('dashboard')],
            ],
        ],
        [
            'title' => 'Main Features',
            'items' => [
                ['label' => 'Crop Recommendation', 'icon' => 'crop', 'href' => '#quick-actions'],
                ['label' => 'Yield Prediction', 'icon' => 'yield', 'href' => '#quick-actions'],
                ['label' => 'Disease Detection', 'icon' => 'disease', 'href' => '#quick-actions'],
                ['label' => 'Fertilizer Recommendation', 'icon' => 'fertilizer', 'href' => '#quick-actions'],
                ['label' => 'Weather Forecast', 'icon' => 'weather', 'href' => '#weather'],
                ['label' => 'Soil Health Check', 'icon' => 'soil', 'href' => '#soil'],
            ],
        ],
        [
            'title' => 'History & Reports',
            'items' => [
                ['label' => 'My History', 'icon' => 'history', 'href' => '#activity'],
                ['label' => 'My Reports', 'icon' => 'reports', 'href' => '#overview'],
                ['label' => 'Saved Results', 'icon' => 'saved', 'href' => '#quick-actions'],
            ],
        ],
        [
            'title' => 'Account',
            'items' => [
                ['label' => 'Profile', 'icon' => 'profile', 'href' => '#profile'],
                ['label' => 'Settings', 'icon' => 'settings', 'href' => '#profile'],
            ],
        ],
    ];

    $stats = [
        ['label' => 'Crop Recommendations', 'value' => '8', 'detail' => 'Total Recommendations', 'icon' => 'crop', 'tone' => 'green', 'spark' => '6,20 22,17 36,18 52,8 66,17 82,16 98,22 116,18 132,22 148,13 164,14 182,7 200,11'],
        ['label' => 'Yield Predictions', 'value' => '6', 'detail' => 'Total Predictions', 'icon' => 'yield', 'tone' => 'blue', 'spark' => '6,23 22,18 36,20 52,9 66,20 82,17 98,24 116,19 132,22 148,12 164,15 182,7 200,10'],
        ['label' => 'Disease Checks', 'value' => '5', 'detail' => 'Total Checks', 'icon' => 'disease', 'tone' => 'purple', 'spark' => '6,23 22,18 36,19 52,9 66,18 82,17 98,20 116,17 132,24 148,17 164,18 182,8 200,14'],
        ['label' => 'Fertilizer Suggestions', 'value' => '7', 'detail' => 'Total Suggestions', 'icon' => 'fertilizer', 'tone' => 'orange', 'spark' => '6,24 22,18 36,19 52,9 66,20 82,18 98,24 116,19 132,22 148,13 164,14 182,10 200,13'],
        ['label' => 'Weather Searches', 'value' => '12', 'detail' => 'Total Searches', 'icon' => 'weather', 'tone' => 'cyan', 'spark' => '6,22 22,19 36,10 52,18 66,15 82,21 98,18 116,24 132,17 148,20 164,9 182,13 200,10'],
    ];

    $activities = [
        ['title' => 'Yield Prediction for Wheat', 'meta' => 'Chandigarh, Punjab - 2 Acres', 'value' => '42 Quintals/Acre', 'time' => '09 Jun 2026, 10:30 AM', 'icon' => 'yield', 'tone' => 'blue'],
        ['title' => 'Crop Recommendation', 'meta' => 'Soil: Loamy - Season: Kharif', 'value' => 'Maize', 'time' => '08 Jun 2026, 04:15 PM', 'icon' => 'crop', 'tone' => 'green'],
        ['title' => 'Disease Detection', 'meta' => 'Crop: Tomato', 'value' => 'Early Blight', 'time' => '08 Jun 2026, 11:20 AM', 'icon' => 'disease', 'tone' => 'orange'],
        ['title' => 'Fertilizer Recommendation', 'meta' => 'Crop: Wheat - Soil: Loamy', 'value' => 'Urea + DAP', 'time' => '07 Jun 2026, 03:45 PM', 'icon' => 'fertilizer', 'tone' => 'amber'],
        ['title' => 'Weather Forecast', 'meta' => 'Chandigarh, Punjab', 'value' => '24&deg;C', 'time' => '07 Jun 2026, 09:10 AM', 'icon' => 'weather', 'tone' => 'cyan'],
    ];

    $quickActions = [
        ['title' => 'Crop Recommendation', 'copy' => 'Find best crops for your field', 'icon' => 'crop', 'tone' => 'green'],
        ['title' => 'Yield Prediction', 'copy' => 'Predict your crop yield', 'icon' => 'yield', 'tone' => 'blue'],
        ['title' => 'Disease Detection', 'copy' => 'Detect plant diseases', 'icon' => 'disease', 'tone' => 'purple'],
        ['title' => 'Fertilizer Recommendation', 'copy' => 'Get fertilizer advice', 'icon' => 'fertilizer', 'tone' => 'orange'],
        ['title' => 'Weather Forecast', 'copy' => 'Check weather updates', 'icon' => 'weather', 'tone' => 'cyan'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard | {{ $brandName }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/dashboard-page.css') }}">
    </head>
    <body class="ag-dashboard-body">
        <div class="ag-dashboard-shell">
            <aside class="ag-sidebar" aria-label="Dashboard sidebar">
                <a class="ag-brand" href="{{ route('home') }}" aria-label="{{ $brandName }} home">
                    <span class="ag-brand__mark">
                        <svg viewBox="0 0 64 64" aria-hidden="true">
                            <path d="M31 58V28" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                            <path d="M31 31C16 30 9 20 8 8c13 1 24 9 23 23Z" fill="#58bf34"/>
                            <path d="M33 34c15-2 23-10 24-23-13 1-24 9-24 23Z" fill="#138b29"/>
                            <path d="M21 45c-8-1-14-6-15-14 9 1 15 6 15 14Z" fill="#87d75a"/>
                        </svg>
                    </span>
                    <span>
                        <strong>{{ $brandName }}</strong>
                        <small>Smart Farming, Better Future</small>
                    </span>
                </a>

                <nav class="ag-sidebar__nav">
                    @foreach ($sidebarGroups as $group)
                        <div class="ag-sidebar__group">
                            @if (!empty($group['title']))
                                <p>{{ $group['title'] }}</p>
                            @endif

                            @foreach ($group['items'] as $item)
                                <a class="ag-sidebar__link{{ !empty($item['active']) ? ' is-active' : '' }}" href="{{ $item['href'] }}">
                                    <span class="ag-icon ag-icon--{{ $item['icon'] }}">
                                        @include('partials.dashboard-icon', ['icon' => $item['icon']])
                                    </span>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="ag-sidebar__group">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="ag-sidebar__link ag-sidebar__button" type="submit">
                                <span class="ag-icon ag-icon--logout">
                                    @include('partials.dashboard-icon', ['icon' => 'logout'])
                                </span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>

                <article class="ag-premium-card">
                    <div class="ag-premium-card__art" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <h2>Go Premium</h2>
                    <p>Unlock advanced features and detailed reports.</p>
                    <a href="#premium">Upgrade Now</a>
                </article>
            </aside>

            <div class="ag-main">
                <header class="ag-topbar">
                    <button class="ag-menu-button" type="button" aria-label="Open menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <label class="ag-search">
                        <span>
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m15.5 15.5 4.5 4.5M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input type="search" placeholder="Search anything..." aria-label="Search dashboard">
                    </label>

                    <div class="ag-topbar__right">
                        <article class="ag-weather-pill">
                            <span class="ag-weather-icon">
                                @include('partials.dashboard-icon', ['icon' => 'weather-full'])
                            </span>
                            <strong>24&deg;C</strong>
                            <small>Partly Cloudy</small>
                        </article>

                        <a class="ag-notification" href="#activity" aria-label="Notifications">
                            @include('partials.dashboard-icon', ['icon' => 'bell'])
                            <span>3</span>
                        </a>

                        <a class="ag-profile-pill" id="profile" href="#profile">
                            <span class="ag-profile-pill__avatar">{{ $userInitial }}</span>
                            <span>
                                <strong>{{ $userName }}</strong>
                                <small>Farmer</small>
                            </span>
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m7 10 5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </header>

                <main class="ag-content">
                    <section class="ag-hero-row">
                        <div>
                            <h1>Welcome back, {{ $userName }}!</h1>
                            <p>Here's what's happening with your farm today.</p>
                        </div>
                        <time class="ag-date-pill" datetime="{{ now()->toDateString() }}">
                            @include('partials.dashboard-icon', ['icon' => 'calendar'])
                            <span>{{ $today }}</span>
                        </time>
                    </section>

                    <section class="ag-stat-grid" aria-label="Farm metrics">
                        @foreach ($stats as $stat)
                            <article class="ag-stat-card ag-card ag-tone-{{ $stat['tone'] }}">
                                <div class="ag-stat-card__top">
                                    <span class="ag-stat-card__icon">
                                        @include('partials.dashboard-icon', ['icon' => $stat['icon']])
                                    </span>
                                    <div>
                                        <h2>{{ $stat['label'] }}</h2>
                                        <strong>{{ $stat['value'] }}</strong>
                                        <p>{{ $stat['detail'] }}</p>
                                    </div>
                                </div>
                                <svg class="ag-sparkline" viewBox="0 0 206 32" preserveAspectRatio="none" aria-hidden="true">
                                    <polyline points="{{ $stat['spark'] }}" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </article>
                        @endforeach
                    </section>

                    <section class="ag-dashboard-grid">
                        <article class="ag-card ag-activity" id="activity">
                            <div class="ag-card__header">
                                <h2>Recent Activity</h2>
                                <a href="#activity">View All</a>
                            </div>
                            <div class="ag-activity__list">
                                @foreach ($activities as $activity)
                                    <div class="ag-activity__item">
                                        <span class="ag-activity__icon ag-tone-{{ $activity['tone'] }}">
                                            @include('partials.dashboard-icon', ['icon' => $activity['icon']])
                                        </span>
                                        <div>
                                            <strong>{{ $activity['title'] }}</strong>
                                            <p>{{ $activity['meta'] }}</p>
                                        </div>
                                        <div class="ag-activity__meta">
                                            <strong>{!! $activity['value'] !!}</strong>
                                            <small>{{ $activity['time'] }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>

                        <article class="ag-card ag-overview" id="overview">
                            <div class="ag-card__header">
                                <h2>Farm Overview</h2>
                                <button type="button">This Month</button>
                            </div>
                            <div class="ag-line-chart" role="img" aria-label="Farm overview line chart">
                                <svg viewBox="0 0 640 260" preserveAspectRatio="none" aria-hidden="true">
                                    <g class="ag-chart-grid">
                                        <line x1="38" y1="36" x2="620" y2="36"/>
                                        <line x1="38" y1="86" x2="620" y2="86"/>
                                        <line x1="38" y1="136" x2="620" y2="136"/>
                                        <line x1="38" y1="186" x2="620" y2="186"/>
                                        <line x1="38" y1="236" x2="620" y2="236"/>
                                    </g>
                                    <g class="ag-chart-axis">
                                        <line x1="38" y1="20" x2="38" y2="236"/>
                                        <line x1="38" y1="236" x2="620" y2="236"/>
                                    </g>
                                    <polyline class="ag-chart-line ag-chart-line--green" points="38,218 92,196 146,170 200,142 254,118 308,126 362,96 416,72 470,60 524,42 580,18 620,10"/>
                                    <polyline class="ag-chart-line ag-chart-line--orange" points="38,230 92,214 146,204 200,178 254,166 308,150 362,144 416,118 470,96 524,94 580,86 620,72"/>
                                    <polyline class="ag-chart-line ag-chart-line--blue" points="38,236 92,226 146,218 200,194 254,184 308,176 362,166 416,138 470,124 524,132 580,116 620,102"/>
                                    <polyline class="ag-chart-line ag-chart-line--purple" points="38,236 92,230 146,226 200,214 254,208 308,194 362,196 416,180 470,166 524,168 580,152 620,138"/>
                                </svg>
                                <div class="ag-chart-labels">
                                    <span>1 Jun</span>
                                    <span>3 Jun</span>
                                    <span>5 Jun</span>
                                    <span>7 Jun</span>
                                    <span>9 Jun</span>
                                </div>
                            </div>
                            <div class="ag-chart-legend">
                                <span><i class="green"></i> Yield Predictions</span>
                                <span><i class="purple"></i> Disease Checks</span>
                                <span><i class="orange"></i> Fertilizer Suggestions</span>
                                <span><i class="blue"></i> Weather Searches</span>
                            </div>
                        </article>
                    </section>

                    <section class="ag-lower-grid">
                        <article class="ag-card ag-quick-actions" id="quick-actions">
                            <div class="ag-card__header">
                                <h2>Quick Actions</h2>
                            </div>
                            <div class="ag-quick-actions__grid">
                                @foreach ($quickActions as $action)
                                    <a class="ag-action-card ag-tone-{{ $action['tone'] }}" href="#quick-actions">
                                        <span>
                                            @include('partials.dashboard-icon', ['icon' => $action['icon']])
                                        </span>
                                        <strong>{{ $action['title'] }}</strong>
                                        <small>{{ $action['copy'] }}</small>
                                    </a>
                                @endforeach
                            </div>
                        </article>

                        <article class="ag-card ag-weather-card" id="weather">
                            <div class="ag-card__header">
                                <h2>Current Weather</h2>
                            </div>
                            <div class="ag-weather-card__body">
                                <div class="ag-weather-card__main">
                                    <span class="ag-weather-card__icon">
                                        @include('partials.dashboard-icon', ['icon' => 'weather-full'])
                                    </span>
                                    <div>
                                        <small>Chandigarh, Punjab</small>
                                        <strong>24&deg;C</strong>
                                        <p>Partly Cloudy</p>
                                    </div>
                                </div>
                                <dl>
                                    <div>
                                        <dt>Humidity</dt>
                                        <dd>62%</dd>
                                    </div>
                                    <div>
                                        <dt>Rainfall</dt>
                                        <dd>0 mm</dd>
                                    </div>
                                    <div>
                                        <dt>Wind</dt>
                                        <dd>12 km/h</dd>
                                    </div>
                                    <div>
                                        <dt>Feels like</dt>
                                        <dd>24&deg;C</dd>
                                    </div>
                                </dl>
                            </div>
                            <a class="ag-outline-button" href="#weather">
                                <span>View Full Forecast</span>
                                @include('partials.dashboard-icon', ['icon' => 'arrow'])
                            </a>
                        </article>
                    </section>

                    <section class="ag-tip-card" id="soil">
                        <div class="ag-tip-card__icon">
                            @include('partials.dashboard-icon', ['icon' => 'tip'])
                        </div>
                        <div>
                            <h2>Farming Tip of the Day</h2>
                            <p>Water your crops early in the morning or late evening to reduce evaporation and improve absorption.</p>
                        </div>
                        <div class="ag-tip-card__field" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </body>
</html>
