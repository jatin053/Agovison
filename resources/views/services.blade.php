@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }

    $currentUser = auth()->user();
    $dashboardUrl = $currentUser ? route('dashboard') : null;
    $profileName = $currentUser?->name ?? 'Farmer';

    $images = [
        'hero' => 'https://images.pexels.com/photos/2889442/pexels-photo-2889442.jpeg?auto=compress&cs=tinysrgb&w=1800',
        'farmer' => 'https://images.pexels.com/photos/12558312/pexels-photo-12558312.jpeg?auto=compress&cs=tinysrgb&w=900',
    ];

    $services = [
        [
            'icon' => 'crop',
            'title' => 'Crop Recommendation',
            'copy' => 'Find the best crop for your field using soil type, nutrients, season, location, and live weather.',
            'inputs' => 'Location, soil type, pH, NPK, season',
            'workflow' => 'We combine your field details with Google location/weather data, then score crops against farming conditions.',
            'result' => 'Recommended crop, confidence score, reason, and practical farming advice.',
            'href' => auth()->check() ? route('dashboard.crop') : route('register'),
            'tone' => 'green',
        ],
        [
            'icon' => 'yield',
            'title' => 'Yield Prediction',
            'copy' => 'Estimate expected production before harvest using crop, land area, season, irrigation, soil, and weather.',
            'inputs' => 'Crop, area, soil, irrigation, season, weather',
            'workflow' => 'AgroVision studies crop context and climate values to estimate whether the field is on track.',
            'result' => 'Expected yield, yield status, and advice to improve output.',
            'href' => auth()->check() ? route('dashboard.yield') : route('register'),
            'tone' => 'blue',
        ],
        [
            'icon' => 'disease',
            'title' => 'Disease Detection',
            'copy' => 'Upload a crop image and record symptoms so the disease module can prepare a diagnosis report.',
            'inputs' => 'Crop, leaf image, affected part, symptoms, field impact',
            'workflow' => 'The Laravel app sends the image and crop context to the Python ML API for analysis.',
            'result' => 'Detected disease, confidence, severity, treatment, prevention, and caution notes.',
            'href' => auth()->check() ? route('dashboard.disease') : route('register'),
            'tone' => 'orange',
        ],
        [
            'icon' => 'fertilizer',
            'title' => 'Fertilizer Recommendation',
            'copy' => 'Choose fertilizer more carefully by matching crop needs with NPK levels, pH, growth stage, and symptoms.',
            'inputs' => 'Crop, soil type, NPK, pH, growth stage, problem',
            'workflow' => 'The system compares nutrient levels with crop requirements and current field symptoms.',
            'result' => 'Recommended fertilizer, dosage advice, application timing, reason, and caution.',
            'href' => auth()->check() ? route('dashboard.fertilizer') : route('register'),
            'tone' => 'purple',
        ],
        [
            'icon' => 'weather',
            'title' => 'Weather Forecast',
            'copy' => 'Check live weather for your farm location before irrigation, spraying, sowing, or field work.',
            'inputs' => 'City, village, or farm location',
            'workflow' => 'Google Places converts the location to coordinates and Google Weather fetches current conditions.',
            'result' => 'Temperature, humidity, rainfall, wind speed, cloud cover, condition, and farming advice.',
            'href' => auth()->check() ? route('dashboard.weather') : route('register'),
            'tone' => 'cyan',
        ],
        [
            'icon' => 'reports',
            'title' => 'Farm Reports',
            'copy' => 'Review all your saved crop, yield, disease, fertilizer, and weather records in one secure place.',
            'inputs' => 'Your saved AgroVision activity',
            'workflow' => 'Reports are generated only from your MySQL records, with filters for crop, location, feature, and date.',
            'result' => 'View details, download PDF, export CSV, and track decisions over time.',
            'href' => auth()->check() ? route('dashboard.reports') : route('register'),
            'tone' => 'olive',
        ],
    ];

    $serviceLinks = array_map(
        fn ($service) => [
            'label' => $service['title'],
            'href' => route('services') . '#' . \Illuminate\Support\Str::slug($service['title']),
        ],
        $services
    );

    $processSteps = [
        ['icon' => 'account', 'title' => 'Create Account', 'copy' => 'Sign up and create your account.'],
        ['icon' => 'details', 'title' => 'Enter Information', 'copy' => 'Provide crop, soil, location and other details.'],
        ['icon' => 'brain', 'title' => 'AI Analysis', 'copy' => 'Our AI analyzes the data and processes it.'],
        ['icon' => 'results', 'title' => 'Get Results', 'copy' => 'Get accurate results and suggestions.'],
        ['icon' => 'action', 'title' => 'Take Action', 'copy' => 'Apply recommendations and improve yield.'],
    ];

    $benefits = [
        ['icon' => 'leaf', 'title' => 'Better Productivity', 'copy' => 'Increase crop yield and overall productivity.'],
        ['icon' => 'cost', 'title' => 'Cost Effective', 'copy' => 'Reduce costs with smart recommendations.'],
        ['icon' => 'shield', 'title' => 'Risk Reduction', 'copy' => 'Minimize risks with early detection and alerts.'],
        ['icon' => 'clock', 'title' => 'Time Saving', 'copy' => 'Save time with quick and accurate results.'],
        ['icon' => 'sustainable', 'title' => 'Sustainable Farming', 'copy' => 'Promote eco-friendly and sustainable farming.'],
    ];

    $serviceDetails = [
        [
            'title' => 'Crop Recommendation',
            'kicker' => 'Plan the right crop before sowing',
            'summary' => 'This module helps a farmer decide which crop suits the selected location, soil type, season, pH value, nitrogen, phosphorus, potassium, temperature, humidity, and rainfall. It is useful when the farmer has land ready but wants a smarter crop choice.',
            'whatWeUse' => ['Google Places for location selection', 'Google Geocoding for latitude and longitude', 'Google Weather for temperature, humidity, rainfall, wind, cloud cover, and condition', 'Manual soil type because Google cannot detect exact soil texture', 'Farmer-entered pH and NPK values'],
            'howItWorks' => ['Farmer enters the field location and soil details', 'AgroVision fills weather values for the selected coordinates', 'The recommendation logic compares crop needs with field conditions', 'The result is saved in the crop recommendations table for future reports'],
            'outputs' => ['Recommended crop', 'Confidence score', 'Reason for recommendation', 'Farming advice'],
        ],
        [
            'title' => 'Yield Prediction',
            'kicker' => 'Estimate production before harvest',
            'summary' => 'Yield Prediction helps farmers understand how much production they may expect from a crop. It uses crop name, location, land area, area unit, season, soil type, irrigation type, previous crop, and live weather values.',
            'whatWeUse' => ['Crop and land area details', 'Season and irrigation type', 'Manual soil type selection', 'Weather values from Google Weather API', 'Previous crop information when available'],
            'howItWorks' => ['Farmer enters crop and land details', 'The system fetches current weather for the selected location', 'AgroVision estimates expected yield from field and climate context', 'The prediction is stored so the farmer can compare results later'],
            'outputs' => ['Expected yield', 'Yield status', 'Advice for improvement'],
        ],
        [
            'title' => 'Disease Detection',
            'kicker' => 'Detect crop disease from image and symptoms',
            'summary' => 'Disease Detection is built for early crop problem checking. The farmer uploads a leaf or affected plant image and enters crop name, affected part, symptoms, location, crop age, symptom start date, field affected percentage, fertilizer used, and pesticide used.',
            'whatWeUse' => ['Uploaded crop image', 'Crop and symptom details', 'Affected plant part', 'Field affected percentage', 'Python ML API endpoint prepared for model prediction'],
            'howItWorks' => ['Laravel validates and stores the uploaded image securely', 'The image and field context are sent to the Python disease API', 'The API returns disease, confidence, severity, cause, treatment, and prevention', 'The report is saved for user history and admin review'],
            'outputs' => ['Detected disease', 'Severity', 'Confidence score', 'Treatment suggestion', 'Prevention advice'],
        ],
        [
            'title' => 'Fertilizer Recommendation',
            'kicker' => 'Apply nutrients with better timing',
            'summary' => 'This module helps farmers avoid random fertilizer use. It uses crop name, location, soil type, season, growth stage, nitrogen, phosphorus, potassium, pH value, and current field problem or symptom.',
            'whatWeUse' => ['Manual soil type', 'Crop growth stage', 'NPK and pH values', 'Current symptom or problem', 'Weather context when useful for field advice'],
            'howItWorks' => ['Farmer enters nutrient values and crop stage', 'AgroVision checks nutrient balance against crop needs', 'The system prepares fertilizer, dosage, timing, reason, and caution', 'The record is saved for farm reports'],
            'outputs' => ['Recommended fertilizer', 'Dosage advice', 'Application timing', 'Reason', 'Caution'],
        ],
        [
            'title' => 'Weather Forecast',
            'kicker' => 'Use live weather before field action',
            'summary' => 'Weather Forecast gives location-based farm weather so farmers can plan irrigation, spraying, sowing, harvesting, and daily work. It uses Google Places and Weather APIs only where they make sense.',
            'whatWeUse' => ['Google Places autocomplete', 'Latitude and longitude from selected location', 'Google Weather API for live weather', 'Optional air quality insight when enabled'],
            'howItWorks' => ['Farmer searches city, village, or location', 'The app gets coordinates for that place', 'Google Weather returns live climate values', 'AgroVision converts weather into farming advice'],
            'outputs' => ['Temperature', 'Humidity', 'Rainfall', 'Wind speed', 'Cloud cover', 'Weather condition', 'Farming advice'],
        ],
        [
            'title' => 'Farm Reports',
            'kicker' => 'Your own farm data in one place',
            'summary' => 'Farm Reports are created only from AgroVision MySQL database records. No external API is used for reports. This keeps reports tied to the farmer account and the actual saved activity inside the platform.',
            'whatWeUse' => ['Crop recommendation records', 'Yield prediction records', 'Disease detection records', 'Fertilizer recommendation records', 'Weather search records'],
            'howItWorks' => ['Logged-in user opens reports', 'The system fetches only that user data', 'Farmer filters by feature, crop, location, and date range', 'Reports can be viewed, downloaded as PDF, or exported as CSV'],
            'outputs' => ['All reports', 'Filtered reports', 'Detail view', 'PDF download', 'CSV export'],
        ],
    ];

    $dataFlow = [
        ['title' => 'Location', 'copy' => 'Farmers search a city, village, or location. Google Places helps autocomplete it and Geocoding converts it into latitude and longitude.'],
        ['title' => 'Weather', 'copy' => 'For prediction modules, the app uses latitude and longitude to fetch temperature, humidity, rainfall, wind speed, cloud cover, and condition.'],
        ['title' => 'Manual Soil', 'copy' => 'Soil type remains a dropdown because Google APIs cannot detect exact soil type like loamy, clay, sandy, black soil, or alluvial.'],
        ['title' => 'Database', 'copy' => 'Every useful input and result is saved with user_id, so users see only their own records and admins can review all activity.'],
    ];

    $securityNotes = [
        'Google API keys stay in .env and are never hardcoded in Blade, JavaScript, or controllers.',
        'User dashboard routes use auth middleware, so guests cannot access private features.',
        'Normal users can view only their own records.',
        'Admin routes use admin middleware and are separated from user dashboard pages.',
        'Farm Reports use the local MySQL database only, not Google or any external data source.',
    ];

    $faqs = [
        ['question' => 'Can Google detect my soil type?', 'answer' => 'No. Google APIs can help with location and weather, but exact soil type must be selected manually for now.'],
        ['question' => 'Why does AgroVision ask for NPK and pH?', 'answer' => 'These values describe soil fertility. They make crop and fertilizer recommendations more useful than location-only suggestions.'],
        ['question' => 'Is disease detection final medical proof for plants?', 'answer' => 'No. It is an AI-based preliminary assessment. Severe crop loss or uncertain results should be checked by an agricultural expert.'],
        ['question' => 'Where do reports come from?', 'answer' => 'Reports come from saved AgroVision database records for the logged-in user. External APIs are not used for Farm Reports.'],
    ];

    $quickLinks = [
        ['label' => 'Home', 'href' => route('home')],
        ['label' => 'About Us', 'href' => route('about')],
        ['label' => 'Services', 'href' => route('services')],
    ];

    if ($dashboardUrl) {
        $quickLinks[] = ['label' => 'Dashboard', 'href' => $dashboardUrl];
    }

    $quickLinks[] = ['label' => 'Contact Us', 'href' => route('contact')];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $brandName }} Services | Smart Farming Solutions</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
    </head>
    <body class="services-page-body" data-page="services">
        <div id="top"></div>

        <header class="services-header" data-header>
            <div class="services-container services-header__inner">
                <a class="services-brand" href="{{ route('home') }}" aria-label="{{ $brandName }} home">
                    <span class="services-brand__mark">
                        <svg viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                            <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#ffffff"/>
                        </svg>
                    </span>
                    <strong>{{ $brandName }}</strong>
                </a>

                <button
                    class="site-nav-toggle services-nav-toggle"
                    type="button"
                    aria-expanded="false"
                    aria-controls="services-nav"
                    data-nav-toggle
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="services-header__menu" id="services-nav" data-nav-panel>
                    <nav class="services-nav" aria-label="Primary">
                        <a class="services-nav__link" href="{{ route('home') }}">Home</a>
                        <a class="services-nav__link" href="{{ route('about') }}">About Us</a>
                        <a class="services-nav__link is-active" href="{{ route('services') }}">Services</a>
                        @auth
                            <a class="services-nav__link" href="{{ route('dashboard') }}">Dashboard</a>
                        @endauth
                        <a class="services-nav__link" href="{{ route('home') }}#blog">Blog</a>
                        <a class="services-nav__link" href="{{ route('contact') }}">Contact Us</a>
                    </nav>

                    <div class="services-header__actions">
                        @guest
                            <a class="site-button site-button--ghost" href="{{ route('login') }}">Login</a>
                            <a class="site-button" href="{{ route('register') }}">Register</a>
                        @else
                            <a class="services-bell" href="{{ route('dashboard') }}" aria-label="Notifications">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M6 16h12l-1.4-1.6V10a4.6 4.6 0 1 0-9.2 0v4.4L6 16ZM10.2 18.3a1.8 1.8 0 0 0 3.6 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span></span>
                            </a>
                            @include('partials.public-auth-actions')
                        @endguest
                    </div>
                </div>
            </div>
        </header>

        <main class="services-main">
            <section class="services-hero" data-section="services">
                <img src="{{ $images['hero'] }}" alt="Green tractor working in a field" loading="eager">
                <div class="services-hero__shade"></div>
                <div class="services-container services-hero__content" data-reveal>
                    <h1>Our Services</h1>
                    <p>Smart farming solutions to help you take better decisions and grow more.</p>
                    <div class="services-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 11.2 12 4l8 7.2V20h-5v-5H9v5H4v-8.8Z" fill="currentColor"/>
                            </svg>
                            <span>Home</span>
                        </a>
                        <span>Services</span>
                    </div>
                </div>
            </section>

            <section class="services-offer">
                <div class="services-container">
                    <div class="services-section-heading" data-reveal>
                        <span>What We Offer</span>
                        <h2>Our Smart Farming Services</h2>
                        <div class="services-title-leaf" aria-hidden="true">
                            <i></i>
                            <svg viewBox="0 0 24 24">
                                <path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="currentColor"/>
                            </svg>
                            <i></i>
                        </div>
                        <p>Advanced AI and data-driven solutions to improve productivity, reduce risks and increase your farming success.</p>
                    </div>

                    <div class="services-grid">
                        @foreach ($services as $service)
                            <article class="service-card service-card--{{ $service['tone'] }}" id="{{ \Illuminate\Support\Str::slug($service['title']) }}" data-reveal>
                                <span class="service-card__icon">
                                    @if ($service['icon'] === 'crop')
                                        <svg viewBox="0 0 96 96" aria-hidden="true">
                                            <ellipse cx="48" cy="69" rx="30" ry="11" fill="#6a4020"/>
                                            <path d="M48 69V35" fill="none" stroke="#278b20" stroke-width="5" stroke-linecap="round"/>
                                            <path d="M48 42c-14-17-30-5-30-5 8 18 25 16 30 5Z" fill="#79d348"/>
                                            <path d="M49 46c18-19 32-4 32-4-10 18-27 15-32 4Z" fill="#2fb540"/>
                                            <path d="M47 61c-11-12-22-4-22-4 6 12 18 11 22 4Z" fill="#9be36c"/>
                                        </svg>
                                    @elseif ($service['icon'] === 'yield')
                                        <svg viewBox="0 0 96 96" aria-hidden="true">
                                            <path d="M18 73h64" stroke="#143b3a" stroke-width="5" stroke-linecap="round"/>
                                            <rect x="24" y="49" width="14" height="24" rx="2" fill="#1f8fd9"/>
                                            <rect x="46" y="37" width="14" height="36" rx="2" fill="#2875d9"/>
                                            <rect x="68" y="24" width="14" height="49" rx="2" fill="#58a636"/>
                                            <path d="M18 48c14-12 22-25 43-21" fill="none" stroke="#1492a5" stroke-width="4" stroke-linecap="round"/>
                                            <path d="M61 26c2-13 16-14 20-14 1 13-9 20-20 14Z" fill="#6fbd3e"/>
                                        </svg>
                                    @elseif ($service['icon'] === 'disease')
                                        <svg viewBox="0 0 96 96" aria-hidden="true">
                                            <path d="M43 18c-22 13-24 43-9 55 13 11 36 5 44-20C61 51 49 37 43 18Z" fill="#68ad37"/>
                                            <path d="M45 24c4 23 1 40-13 54" fill="none" stroke="#2f7b27" stroke-width="4" stroke-linecap="round"/>
                                            <circle cx="39" cy="43" r="3" fill="#e86d2f"/>
                                            <circle cx="55" cy="51" r="3" fill="#e86d2f"/>
                                            <circle cx="49" cy="64" r="3" fill="#e86d2f"/>
                                            <circle cx="64" cy="58" r="14" fill="none" stroke="#1f2f35" stroke-width="5"/>
                                            <path d="m74 69 12 12" stroke="#1f2f35" stroke-width="6" stroke-linecap="round"/>
                                            <path d="m59 58 4 4 8-9" fill="none" stroke="#1b8e43" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @elseif ($service['icon'] === 'fertilizer')
                                        <svg viewBox="0 0 96 96" aria-hidden="true">
                                            <path d="M26 23h43l7 53c1 6-3 10-9 10H30c-6 0-10-4-9-10l5-53Z" fill="#7b4a2a"/>
                                            <path d="M30 14h37l2 14H27l3-14Z" fill="#6a3d23"/>
                                            <circle cx="48" cy="52" r="18" fill="#f4f5d8"/>
                                            <text x="48" y="57" text-anchor="middle" font-size="14" font-weight="700" fill="#3c4b28">NPK</text>
                                            <path d="M70 72c-10-2-15 4-17 12 10 1 17-4 17-12Z" fill="#57b735"/>
                                        </svg>
                                    @elseif ($service['icon'] === 'weather')
                                        <svg viewBox="0 0 96 96" aria-hidden="true">
                                            <circle cx="36" cy="32" r="15" fill="#ffba2e"/>
                                            <path d="M36 9v7M36 48v7M12 32h7M53 32h7M19 15l5 5M53 15l-5 5" stroke="#ff9f1c" stroke-width="4" stroke-linecap="round"/>
                                            <path d="M29 68h43a15 15 0 0 0 0-30 19 19 0 0 0-36-6 15 15 0 0 0-7 29Z" fill="#3aa7f5"/>
                                            <path d="M33 80v8M49 80v8M65 80v8" stroke="#2377ce" stroke-width="5" stroke-linecap="round"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 96 96" aria-hidden="true">
                                            <rect x="24" y="16" width="48" height="66" rx="6" fill="#f7f8ef" stroke="#5b8347" stroke-width="5"/>
                                            <path d="M38 12h20l3 12H35l3-12Z" fill="#4a863f"/>
                                            <circle cx="50" cy="50" r="14" fill="#d8eacd"/>
                                            <path d="M50 50V36a14 14 0 0 1 14 14H50Z" fill="#2e91d1"/>
                                            <path d="M50 50h14a14 14 0 1 1-14-14v14Z" fill="#84bf39"/>
                                            <path d="M34 70h31" stroke="#80956b" stroke-width="5" stroke-linecap="round"/>
                                        </svg>
                                    @endif
                                </span>
                                <div class="service-card__body">
                                    <h3>{{ $service['title'] }}</h3>
                                    <p>{{ $service['copy'] }}</p>
                                    <dl class="service-card__facts">
                                        <div>
                                            <dt>Input</dt>
                                            <dd>{{ $service['inputs'] }}</dd>
                                        </div>
                                        <div>
                                            <dt>Result</dt>
                                            <dd>{{ $service['result'] }}</dd>
                                        </div>
                                    </dl>
                                    <div class="service-card__workflow">
                                        <strong>How we work</strong>
                                        <span>{{ $service['workflow'] }}</span>
                                    </div>
                                    <a href="{{ $service['href'] }}">
                                        <span>Open Service</span>
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-deep-dive">
                <div class="services-container">
                    <div class="services-section-heading services-section-heading--compact" data-reveal>
                        <span>Complete Service Guide</span>
                        <h2>What AgroVision Does For Farmers</h2>
                        <p>Each module is designed for a real farming decision, from choosing a crop to saving reports after the result.</p>
                    </div>

                    <div class="services-detail-list">
                        @foreach ($serviceDetails as $detail)
                            <article class="services-detail-card" id="details-{{ \Illuminate\Support\Str::slug($detail['title']) }}" data-reveal>
                                <div class="services-detail-card__header">
                                    <span>{{ $detail['kicker'] }}</span>
                                    <h3>{{ $detail['title'] }}</h3>
                                    <p>{{ $detail['summary'] }}</p>
                                </div>

                                <div class="services-detail-card__columns">
                                    <div>
                                        <h4>Data We Use</h4>
                                        <ul>
                                            @foreach ($detail['whatWeUse'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <h4>How It Works</h4>
                                        <ul>
                                            @foreach ($detail['howItWorks'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <h4>Result You Get</h4>
                                        <ul>
                                            @foreach ($detail['outputs'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-data-flow">
                <div class="services-container">
                    <div class="services-section-heading services-section-heading--compact" data-reveal>
                        <span>Data Flow</span>
                        <h2>How Google APIs And AgroVision Work Together</h2>
                        <p>We use Google APIs only where they are useful: location autocomplete, coordinates, and weather. Prediction records and reports stay inside your database.</p>
                    </div>

                    <div class="services-flow-grid">
                        @foreach ($dataFlow as $index => $item)
                            <article class="services-flow-card" data-reveal>
                                <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-trust">
                <div class="services-container services-trust__inner">
                    <div class="services-trust__content" data-reveal>
                        <span>Security And Rules</span>
                        <h2>Built For Private User Records</h2>
                        <p>AgroVision stores farming results with the logged-in user account. A farmer sees their own crop, yield, disease, fertilizer, weather, and report data. Admins can review platform activity from the admin panel.</p>
                    </div>

                    <div class="services-trust__list" data-reveal>
                        @foreach ($securityNotes as $note)
                            <div>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="m5 12 4 4 10-10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $note }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-process">
                <div class="services-container">
                    <div class="services-section-heading services-section-heading--compact" data-reveal>
                        <span>How It Works</span>
                        <h2>Our Simple Process</h2>
                        <div class="services-title-leaf" aria-hidden="true">
                            <i></i>
                            <svg viewBox="0 0 24 24"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="currentColor"/></svg>
                            <i></i>
                        </div>
                    </div>

                    <div class="services-process__steps">
                        @foreach ($processSteps as $index => $step)
                            <article class="services-process__step" data-reveal>
                                <span class="services-process__number">{{ $index + 1 }}</span>
                                <span class="services-process__icon">
                                    @if ($step['icon'] === 'account')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4.8 20c1.8-4.1 4.2-6.2 7.2-6.2s5.4 2.1 7.2 6.2" fill="currentColor"/></svg>
                                    @elseif ($step['icon'] === 'details')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 4.5h10v2h2v16H5v-16h2v-2Zm2 6h6M9 14h6M9 18h4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @elseif ($step['icon'] === 'brain')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.2 5.5A3.3 3.3 0 0 1 12 3.8a3.3 3.3 0 0 1 2.8 1.7 3.5 3.5 0 0 1 3.4 4.7 3.5 3.5 0 0 1-2.4 6.1h-7.6a3.5 3.5 0 0 1-2.4-6.1 3.5 3.5 0 0 1 3.4-4.7Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 4v16M8 10h4M12 14h4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @elseif ($step['icon'] === 'results')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 16v-5M12 16V7M17 16V4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @else
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21v-8M12 13c-4.2-.3-6.6-2.7-7.2-7 4.3.5 6.7 2.8 7.2 7ZM12 13c.5-4.2 2.9-6.5 7.2-7-.6 4.3-3 6.7-7.2 7Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @endif
                                </span>
                                <h3>{{ $step['title'] }}</h3>
                                <p>{{ $step['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-benefits">
                <div class="services-container">
                    <div class="services-section-heading services-section-heading--compact" data-reveal>
                        <span>Why Choose Us</span>
                        <h2>Benefits You Get</h2>
                    </div>

                    <div class="services-benefits__grid">
                        @foreach ($benefits as $benefit)
                            <article class="services-benefit" data-reveal>
                                <span>
                                    @if ($benefit['icon'] === 'leaf')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4c-8.8.8-14.5 5.7-16 15 8.8-.8 14.5-5.7 16-15ZM5 19c3.7-4.6 7.6-8 12-10.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @elseif ($benefit['icon'] === 'cost')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 6h10M7 10h10M8 6c5.8 0 5.8 8 0 8l7 6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @elseif ($benefit['icon'] === 'shield')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.8 18.5 6v5.5c0 4-2.7 7.4-6.5 8.8-3.8-1.4-6.5-4.8-6.5-8.8V6L12 3.8Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m9.4 12.2 1.7 1.8 3.7-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @elseif ($benefit['icon'] === 'clock')
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7v5l3.4 2M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @else
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21v-8M12 13c-4.2-.3-6.6-2.7-7.2-7 4.3.5 6.7 2.8 7.2 7ZM12 13c.5-4.2 2.9-6.5 7.2-7-.6 4.3-3 6.7-7.2 7Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @endif
                                </span>
                                <h3>{{ $benefit['title'] }}</h3>
                                <p>{{ $benefit['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-faq">
                <div class="services-container">
                    <div class="services-section-heading services-section-heading--compact" data-reveal>
                        <span>Questions</span>
                        <h2>Clear Answers Before You Use The Services</h2>
                    </div>

                    <div class="services-faq__grid">
                        @foreach ($faqs as $faq)
                            <article class="services-faq__item" data-reveal>
                                <h3>{{ $faq['question'] }}</h3>
                                <p>{{ $faq['answer'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="agro-long-section">
                <div class="services-container">
                    <div class="agro-long-section__header" data-reveal>
                        <span class="section-chip section-chip--soft">Service Details</span>
                        <h2>What each AgroVision service actually does for the farmer.</h2>
                        <p>Every service is connected to a real farm question. The aim is not to show random data, but to guide the farmer toward a clear next action.</p>
                    </div>

                    <div class="agro-long-grid" data-reveal>
                        <article class="agro-long-card">
                            <strong>Planning services</strong>
                            <p>Crop recommendation and yield prediction help farmers decide what to grow and what production level may be expected. These modules use crop details, season, soil, area, irrigation, nutrients and weather context.</p>
                            <ul>
                                <li>Better crop selection by soil and season.</li>
                                <li>Yield estimate with status and advice.</li>
                                <li>Saved reports for future comparison.</li>
                            </ul>
                        </article>
                        <article class="agro-long-card">
                            <strong>Protection services</strong>
                            <p>Disease detection and weather forecast help farmers react before damage becomes serious. Disease uses image upload and symptoms, while weather uses the selected location to return live farm conditions.</p>
                            <ul>
                                <li>Disease name, severity, confidence and treatment.</li>
                                <li>Weather condition, rainfall, wind and cloud cover.</li>
                                <li>Practical farming advice for daily action.</li>
                            </ul>
                        </article>
                        <article class="agro-long-card">
                            <strong>Nutrition services</strong>
                            <p>Fertilizer recommendation uses crop, soil type, pH, NPK, growth stage, current problem and saved soil profile data to suggest safer fertilizer guidance.</p>
                            <ul>
                                <li>Recommended fertilizer and application timing.</li>
                                <li>Reason, caution and alternative options.</li>
                                <li>Admin-managed fertilizer rules and master data.</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>

            <section class="services-cta">
                <img src="{{ $images['farmer'] }}" alt="Farmer working in a lush green field" loading="lazy">
                <div class="services-container services-cta__inner" data-reveal>
                    <div>
                        <h2>Ready to Grow Better?</h2>
                        <p>Join thousands of smart farmers using AgroVision.</p>
                    </div>
                    <a class="services-cta__button" href="{{ auth()->check() ? route('dashboard') : route('register') }}">
                        <span>Get Started Now</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </section>
        </main>

        <footer class="services-footer">
            <div class="services-container services-footer__main">
                <div class="services-footer__brand">
                    <a class="services-brand services-brand--footer" href="{{ route('home') }}">
                        <span class="services-brand__mark">
                            <svg viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#ffffff"/>
                            </svg>
                        </span>
                        <strong>{{ $brandName }}</strong>
                    </a>
                    <p>Smart farming solutions powered by AI and real-time data to help farmers grow better.</p>
                    <div class="services-footer__socials">
                        <a href="{{ route('contact') }}" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/></svg></a>
                        <a href="{{ route('contact') }}" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 8.5a3 3 0 0 0-2.1-2.1C17 6 12 6 12 6s-5 0-6.9.4A3 3 0 0 0 3 8.5 31.7 31.7 0 0 0 2.6 12 31.7 31.7 0 0 0 3 15.5a3 3 0 0 0 2.1 2.1C7 18 12 18 12 18s5 0 6.9-.4a3 3 0 0 0 2.1-2.1c.3-1.1.4-2.3.4-3.5s-.1-2.4-.4-3.5ZM10 15V9l5 3-5 3Z" fill="currentColor"/></svg></a>
                    </div>
                </div>

                <div class="services-footer__column">
                    <h3>Quick Links</h3>
                    <ul>
                        @foreach ($quickLinks as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="services-footer__column">
                    <h3>Our Services</h3>
                    <ul>
                        @foreach ($serviceLinks as $service)
                            <li><a href="{{ $service['href'] }}">{{ $service['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="services-footer__column">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="{{ route('contact') }}">Help Center</a></li>
                        <li><a href="{{ route('contact') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('contact') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('contact') }}">FAQ</a></li>
                    </ul>
                </div>

                <div class="services-footer__column">
                    <h3>Contact Us</h3>
                    <ul class="services-footer__contact">
                        <li>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6.8 4.9 2.4-.7a1.3 1.3 0 0 1 1.5.7l1.1 2.7a1.3 1.3 0 0 1-.3 1.4l-1.3 1.3a13.9 13.9 0 0 0 3.5 3.5l1.3-1.3a1.3 1.3 0 0 1 1.4-.3l2.7 1.1a1.3 1.3 0 0 1 .7 1.5l-.7 2.4a1.3 1.3 0 0 1-1.3 1C11.2 19.5 4.5 12.8 4.5 6.2a1.3 1.3 0 0 1 1-1.3Z" fill="currentColor"/></svg>
                            <a href="tel:+917018741392">+91 70187 41392</a>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 6.5h15v11h-15zM5.6 7.4l6.4 5 6.4-5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <a href="mailto:support@agrovision.com">support@agrovision.com</a>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.5c-3.1 0-5.5 2.4-5.5 5.4 0 4.2 5.5 11.6 5.5 11.6s5.5-7.4 5.5-11.6c0-3-2.4-5.4-5.5-5.4Zm0 7.5a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2Z" fill="currentColor"/></svg>
                            <span>Chandigarh, Punjab, India</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="services-footer__bottom">
                <p>&copy; {{ now()->year }} {{ $brandName }}. All rights reserved.</p>
            </div>
        </footer>

        @include('partials.chat-widget')

        <a class="site-backtotop services-backtotop" href="#top" data-backtotop aria-label="Back to top">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m7 14 5-5 5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <script src="{{ asset('js/home-page.js') }}" defer></script>
        <script src="{{ asset('js/chat-widget.js') }}" defer></script>
    </body>
</html>
