@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ ($pageTitle ?? 'Account') . ' | ' . $brandName }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
    </head>
    <body class="auth-body auth-body--{{ $pageTheme ?? 'login' }}">
        <div class="auth-scene">
            <main class="auth-shell">
                <section class="auth-panel">
                    <div class="auth-card">
                        <a class="auth-brand" href="{{ url('/') }}">
                            <span class="auth-brand__mark">
                                <svg viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                    <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#05210b"/>
                                    <path d="M31.2 12.3c1.5 7.1-1.6 14.6-8 19.2-3.8 2.8-8.5 4.3-13.2 4.2 4.6 2.7 10.9 3 16.4.9 5.4-2.1 10.3-6.9 12.5-12.2 2.1-5 1.4-10-1.7-13.1-1.8-1.7-3.9-2.7-6-3Z" fill="#b8ff53" opacity=".72"/>
                                </svg>
                            </span>
                            <span class="auth-brand__text">{{ $brandName }}</span>
                        </a>

                        <p class="auth-eyebrow">{{ $eyebrow ?? 'WELCOME BACK' }}</p>
                        <h1 class="auth-title">{!! $heading ?? 'Access your smart farming dashboard.' !!}</h1>
                        <p class="auth-copy">{{ $subheading ?? 'Sign in to continue.' }}</p>

                        @if (session('status'))
                            <div class="auth-status">{{ session('status') }}</div>
                        @endif

                        @yield('content')
                    </div>
                </section>

                <aside class="auth-stage" aria-hidden="true">
                    <div class="auth-stage__mist"></div>
                    <div class="auth-stage__sun"></div>
                    <div class="auth-stage__ring auth-stage__ring--one"></div>
                    <div class="auth-stage__ring auth-stage__ring--two"></div>
                    <div class="auth-stage__grid"></div>

                    <div class="auth-stage__tablet">
                        <div class="auth-stage__tablet-shell">
                            <div class="auth-stage__tablet-sidebar">
                                <span class="auth-stage__sidebar-brand">
                                    <svg viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                        <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#05210b"/>
                                    </svg>
                                </span>
                                <span class="auth-stage__sidebar-icon"></span>
                                <span class="auth-stage__sidebar-icon"></span>
                                <span class="auth-stage__sidebar-icon"></span>
                                <span class="auth-stage__sidebar-icon"></span>
                                <span class="auth-stage__sidebar-icon"></span>
                            </div>

                            <div class="auth-stage__tablet-main">
                                <div class="auth-stage__tablet-topbar">
                                    <span class="auth-stage__tablet-title">{{ $stageTitle ?? 'Farm Overview' }}</span>
                                    <div class="auth-stage__tablet-actions">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="auth-stage__tablet-grid">
                                    <div class="auth-stage__map-card">
                                        <div class="auth-stage__map-art"></div>
                                    </div>

                                    <article class="auth-stage__metric-card">
                                        <span class="auth-stage__metric-label">Crop Health</span>
                                        <div class="auth-stage__metric-ring" style="--progress: {{ $healthProgress ?? 92 }}">
                                            <strong>{{ $healthValue ?? '92%' }}</strong>
                                        </div>
                                        <p>{{ $healthStatus ?? 'Healthy' }}</p>
                                    </article>

                                    <article class="auth-stage__metric-card">
                                        <span class="auth-stage__metric-label">Soil Moisture</span>
                                        <div class="auth-stage__metric-ring auth-stage__metric-ring--soft" style="--progress: {{ $moistureProgress ?? 68 }}">
                                            <strong>{{ $moistureValue ?? '68%' }}</strong>
                                        </div>
                                        <p>{{ $moistureStatus ?? 'Optimal' }}</p>
                                    </article>

                                    <article class="auth-stage__chart-card">
                                        <span class="auth-stage__metric-label">Yield Prediction</span>
                                        <svg viewBox="0 0 320 150" preserveAspectRatio="none" aria-hidden="true">
                                            <path d="M12 124H308" />
                                            <path d="M18 114l34-16 30 10 38-32 30 13 32-40 38 12 36-34" />
                                        </svg>
                                        <div class="auth-stage__chart-badge">
                                            <strong>{{ $chartValue ?? '+18%' }}</strong>
                                            <span>{{ $chartLabel ?? 'vs last season' }}</span>
                                        </div>
                                    </article>

                                    <article class="auth-stage__weather-card">
                                        <span class="auth-stage__metric-label">Weather</span>
                                        <div class="auth-stage__weather-icon">
                                            <span class="auth-stage__sun-dot"></span>
                                            <span class="auth-stage__cloud"></span>
                                        </div>
                                        <strong>{{ $weatherValue ?? '28°C' }}</strong>
                                        <p>{{ $weatherLabel ?? 'Partly Cloudy' }}</p>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auth-stage__feature-card">
                        <span class="auth-stage__pill">{{ $visualPill ?? 'LOGIN FLOW' }}</span>
                        <h2>{{ $visualTitle ?? 'Monitor your farm with clarity' }}</h2>
                        <p>{{ $visualCopy ?? 'Log in to access AI-powered reports, real-time insights, and personalized recommendations to help your crops thrive.' }}</p>

                        <div class="auth-stage__feature-list">
                            <div class="auth-stage__feature-row">
                                <span class="auth-stage__feature-icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4.2 0-7 2.1-7 5v1h14v-1c0-2.9-2.8-5-7-5Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span>{{ $statLabelOne ?? 'Mode' }}</span>
                                <strong>{{ $statValueOne ?? 'Login' }}</strong>
                            </div>

                            <div class="auth-stage__feature-row">
                                <span class="auth-stage__feature-icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M4 6h16v9H4zM8 20h8M12 15v5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span>{{ $statLabelTwo ?? 'Visual' }}</span>
                                <strong>{{ $statValueTwo ?? 'Smart Farming UI' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="auth-stage__pedestal"></div>

                    <div class="auth-stage__leaf-orb">
                        <div class="auth-stage__leaf-rings"></div>
                        <div class="auth-stage__leaf-core">
                            <svg viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M24 8c-7 4.1-11 10.3-11 17.2 0 8.2 5.5 14.8 11 14.8s11-6.6 11-14.8C35 18.3 31 12.1 24 8Z" fill="none" stroke="currentColor" stroke-width="1.9"/>
                                <path d="M24 17.6V39M24 24.7c-3.7-.7-6.6-3.4-7.7-7.2M24 28.7c3.7-.7 6.6-3.4 7.7-7.2" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>

                    <div class="auth-stage__sensor">
                        <div class="auth-stage__signal"></div>
                        <div class="auth-stage__anemometer">
                            <span></span>
                            <span></span>
                            <span></span>
                            <i></i>
                        </div>
                        <div class="auth-stage__solar-panel"></div>
                        <div class="auth-stage__sensor-pole"></div>
                        <div class="auth-stage__sensor-box">
                            <span class="auth-stage__sensor-logo">
                                <svg viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </aside>
            </main>
        </div>

        <script>
            document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
                toggle.addEventListener('click', () => {
                    const field = document.getElementById(toggle.getAttribute('data-password-toggle'));

                    if (!field) {
                        return;
                    }

                    const nextType = field.type === 'password' ? 'text' : 'password';
                    field.type = nextType;
                    toggle.setAttribute('aria-label', nextType === 'password' ? 'Show password' : 'Hide password');
                    toggle.classList.toggle('is-active', nextType === 'text');
                });
            });
        </script>
    </body>
</html>
