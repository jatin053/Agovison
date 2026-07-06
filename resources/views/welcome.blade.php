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
        'hero' => 'https://plus.unsplash.com/premium_photo-1661495969007-06e175a86112?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'tractor' => 'https://images.unsplash.com/photo-1730048315637-90db992fc946?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'sunrise' => 'https://images.unsplash.com/photo-1762871673363-83dbb1ffc26f?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'sprout' => 'https://images.unsplash.com/photo-1775608148833-b949ae858aec?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'seedling' => 'https://images.unsplash.com/photo-1752775312083-1cefe2f93358?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'tablet' => 'https://plus.unsplash.com/premium_photo-1661717831448-691090b31427?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
        'fieldRows' => 'https://images.unsplash.com/photo-1663326224681-2eda4e0d9f43?auto=format&fit=crop&fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000',
    ];

    $heroSlides = [
        [
            'eyebrow' => 'AI Powered Agriculture',
            'title' => 'Smart Crop Monitoring &',
            'highlight' => 'Yield Prediction',
            'title_end' => 'System',
            'copy' => 'AgroVision is an AI-powered platform that helps farmers make smarter decisions. Get crop recommendations, predict yield, detect diseases, get fertilizer suggestions and real-time weather updates.',
            'image' => $images['hero'],
            'metrics' => [
                ['label' => 'Crop Health', 'value' => 'Good', 'detail' => null, 'icon' => 'crop'],
                ['label' => 'Weather', 'value' => '28°C', 'detail' => 'Partly Cloudy', 'icon' => 'weather'],
                ['label' => 'Yield Prediction', 'value' => '32.5 q/acre', 'detail' => null, 'icon' => 'yield'],
                ['label' => 'Soil Status', 'value' => 'Optimal', 'detail' => null, 'icon' => 'soil'],
            ],
        ],
        [
            'eyebrow' => 'Precision Farm Intelligence',
            'title' => 'Weather, Soil &',
            'highlight' => 'Disease Insights',
            'title_end' => 'In One View',
            'copy' => 'Track moisture, forecast rainfall, identify disease risk early, and see field-level recommendations in one beautiful control layer built for modern agriculture.',
            'image' => $images['fieldRows'],
            'metrics' => [
                ['label' => 'Soil Moisture', 'value' => '64%', 'detail' => 'Irrigation Ready', 'icon' => 'drop'],
                ['label' => 'Disease Risk', 'value' => 'Low', 'detail' => 'Leaf Scan Active', 'icon' => 'shield'],
                ['label' => 'Rain Window', 'value' => '18 hrs', 'detail' => 'Clear Forecast', 'icon' => 'clock'],
                ['label' => 'AI Accuracy', 'value' => '98%', 'detail' => 'Trusted Model', 'icon' => 'data'],
            ],
        ],
        [
            'eyebrow' => 'Harvest Smarter With AI',
            'title' => 'Stronger Fields,',
            'highlight' => 'Better Harvests',
            'title_end' => '& Faster Decisions',
            'copy' => 'From crop planning to harvest timing, AgroVision helps farmers reduce waste, save water, and improve productivity with clear, real-time recommendations.',
            'image' => $images['tractor'],
            'metrics' => [
                ['label' => 'Farm Efficiency', 'value' => '+24%', 'detail' => 'Season Growth', 'icon' => 'yield'],
                ['label' => 'Smart Alerts', 'value' => '6 Live', 'detail' => 'Field Notifications', 'icon' => 'bell'],
                ['label' => 'Water Saving', 'value' => '-18%', 'detail' => 'Smarter Irrigation', 'icon' => 'water'],
                ['label' => 'Harvest Plan', 'value' => 'Ready', 'detail' => 'Action Scheduled', 'icon' => 'leaf'],
            ],
        ],
    ];

    $navItems = [
        ['label' => 'Home', 'href' => '#home', 'anchor' => true],
        ['label' => 'About', 'href' => route('about'), 'anchor' => false],
        ['label' => 'Features', 'href' => route('features'), 'anchor' => false],
    ];

    if ($dashboardUrl) {
        $navItems[] = ['label' => 'Dashboard', 'href' => $dashboardUrl, 'anchor' => false];
    }

    $navItems[] = ['label' => 'Services', 'children' => $serviceLinks];
    $navItems[] = ['label' => 'Contact', 'href' => route('contact'), 'anchor' => false];

    $featureCards = [
        [
            'icon' => 'crop',
            'title' => 'Crop Recommendation',
            'copy' => 'Get the best crop suggestions based on soil health, weather, season, and local farm conditions.',
        ],
        [
            'icon' => 'yield',
            'title' => 'Yield Prediction',
            'copy' => 'Predict yield accurately using AI models trained on crop, weather, field, and historical season data.',
        ],
        [
            'icon' => 'disease',
            'title' => 'Disease Detection',
            'copy' => 'Detect crop diseases early using image analysis so farmers can respond before damage spreads.',
        ],
        [
            'icon' => 'fertilizer',
            'title' => 'Fertilizer Recommendation',
            'copy' => 'Get smart fertilizer suggestions based on soil nutrients and crop stage to improve soil health.',
        ],
        [
            'icon' => 'weather',
            'title' => 'Weather Forecast',
            'copy' => 'Stay ahead with accurate location-based weather updates for irrigation, spraying, and harvesting.',
        ],
        [
            'icon' => 'dashboard',
            'title' => 'Real-time Dashboard',
            'copy' => 'Monitor farm data, alerts, crop performance, and recommendations from one clean dashboard.',
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

    $aboutPoints = [
        'AI based smart farming solutions',
        'Accurate predictions and recommendations',
        'Easy to use and farmer friendly',
        'Increase productivity and reduce waste',
    ];

    $stats = [
        ['value' => 1000, 'suffix' => '+', 'label' => 'Happy Farmers', 'icon' => 'users'],
        ['value' => 2500, 'suffix' => '+', 'label' => 'Fields Monitored', 'icon' => 'field'],
        ['value' => 98, 'suffix' => '%', 'label' => 'Prediction Accuracy', 'icon' => 'chart'],
        ['value' => 50, 'suffix' => '+', 'label' => 'Crop Types', 'icon' => 'leaf'],
        ['value' => 24, 'suffix' => '/7', 'label' => 'Support Available', 'icon' => 'clock'],
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

    $articles = [
        [
            'date' => '12 May 2024',
            'title' => '5 Tips to Improve Soil Health Naturally',
            'image' => $images['seedling'],
        ],
        [
            'date' => '10 May 2024',
            'title' => 'Best Time to Irrigate Different Crops',
            'image' => $images['sunrise'],
        ],
        [
            'date' => '08 May 2024',
            'title' => 'How Weather Forecasting Helps Farmers',
            'image' => $images['tablet'],
        ],
        [
            'date' => '05 May 2024',
            'title' => 'Common Crop Diseases and How to Prevent Them',
            'image' => $images['sprout'],
        ],
    ];

    $platformSections = [
        [
            'eyebrow' => 'Google Location Intelligence',
            'title' => 'Location-aware farming from the first input',
            'copy' => 'Farmers can search a city, village, or field location using Google Places autocomplete. AgroVision converts that selected place into latitude and longitude, then reuses the location across crop recommendation, yield prediction, fertilizer planning, weather forecast, and report filters.',
            'image' => $images['tablet'],
            'points' => ['Village and city autocomplete', 'Latitude and longitude capture', 'Cleaner location records in MySQL'],
        ],
        [
            'eyebrow' => 'Live Weather Context',
            'title' => 'Weather data that directly supports decisions',
            'copy' => 'Temperature, humidity, rainfall, wind speed, cloud cover, and weather condition are pulled for the selected coordinates. That weather context helps farmers decide when to irrigate, spray, fertilize, and prepare for crop stress.',
            'image' => $images['sunrise'],
            'points' => ['Temperature and humidity', 'Rainfall and wind speed', 'Weather-based farming advice'],
        ],
        [
            'eyebrow' => 'Manual Soil Accuracy',
            'title' => 'Soil type stays farmer-controlled',
            'copy' => 'Google APIs are useful for places and weather, but they do not detect exact soil type. AgroVision keeps soil type as a manual dropdown so farmers choose Loamy, Clay, Sandy, Black Soil, or Alluvial based on their field knowledge or soil test.',
            'image' => $images['seedling'],
            'points' => ['Manual soil dropdown', 'pH and NPK inputs', 'Ready for future SoilGrids integration'],
        ],
    ];

    $moduleShowcase = [
        [
            'label' => 'Crop Recommendation',
            'copy' => 'Combines selected location, manual soil type, season, NPK, pH, and live weather values to suggest a crop with confidence, reason, and farming advice.',
            'image' => $images['fieldRows'],
        ],
        [
            'label' => 'Yield Prediction',
            'copy' => 'Uses crop name, land area, season, irrigation method, soil type, previous crop, and weather values to estimate expected production and risk status.',
            'image' => $images['tractor'],
        ],
        [
            'label' => 'Fertilizer Recommendation',
            'copy' => 'Reads crop stage, NPK levels, pH value, symptoms, season, and soil type to recommend fertilizer, dosage guidance, application timing, and caution.',
            'image' => $images['sprout'],
        ],
        [
            'label' => 'Disease Detection',
            'copy' => 'Accepts a leaf image upload and saves the detection record. The current dummy logic is ready to be replaced by a Python machine learning API.',
            'image' => $images['seedling'],
        ],
    ];

    $journeySteps = [
        ['step' => '01', 'title' => 'Select Location', 'copy' => 'The farmer types a village, city, or farm area and selects a Google Places result.'],
        ['step' => '02', 'title' => 'Add Farm Details', 'copy' => 'The farmer enters crop, soil type, season, nutrients, pH, irrigation, and land information.'],
        ['step' => '03', 'title' => 'Fetch Weather', 'copy' => 'AgroVision reads current weather from coordinates and auto-fills climate inputs where useful.'],
        ['step' => '04', 'title' => 'Generate Result', 'copy' => 'The system saves inputs and produces recommendation, prediction, treatment, or forecast output.'],
        ['step' => '05', 'title' => 'Review Reports', 'copy' => 'Saved MySQL records become farm reports with filters, PDF download, and CSV export.'],
    ];

    $reportHighlights = [
        'Farm Reports never call external APIs; they use only saved MySQL records.',
        'Normal users can see only their own crop, yield, disease, fertilizer, and weather history.',
        'Admins can filter all user activity by feature type, user, crop, location, and result.',
        'PDF and CSV exports help farmers keep records for planning, visits, and seasonal review.',
    ];

    $faqItems = [
        [
            'question' => 'Does Google detect soil type?',
            'answer' => 'No. Soil type is kept manual because Google APIs do not identify exact farm soil like Loamy, Clay, Sandy, Black Soil, or Alluvial.',
        ],
        [
            'question' => 'Which modules use Google APIs?',
            'answer' => 'Location autocomplete and geocoding support crop, yield, fertilizer, weather, and report filtering. Weather data supports crop, yield, fertilizer, and weather forecast modules.',
        ],
        [
            'question' => 'Does disease detection use weather?',
            'answer' => 'No. Disease detection is image-upload based and prepared for a future Python ML model.',
        ],
        [
            'question' => 'Are farm reports generated from Google?',
            'answer' => 'No. Farm reports are generated from AgroVision MySQL tables only.',
        ],
    ];

    $footerLinks = [
        ['label' => 'Home', 'href' => route('home')],
        ['label' => 'About Us', 'href' => route('about')],
        ['label' => 'Features', 'href' => route('features')],
    ];

    if ($dashboardUrl) {
        $footerLinks[] = ['label' => 'Dashboard', 'href' => $dashboardUrl];
    } else {
        $footerLinks[] = ['label' => 'Register', 'href' => route('register')];
    }

    $footerLinks[] = ['label' => 'Contact Us', 'href' => route('contact')];

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $brandName }} | Smart Farming, Better Future</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
    </head>
    <body class="home-body" data-page="home">
        <div class="site-topbar">
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
                    <a class="site-topbar__link" href="mailto:info@agrovision.com">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4.5 6.5h15v11h-15z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                <path d="m5.6 7.4 6.4 5 6.4-5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>info@agrovision.com</span>
                    </a>
                </div>

                <div class="site-topbar__group site-topbar__group--right">
                    <span class="site-topbar__follow">Follow Us:</span>
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
                        <a href="#contact" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/>
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
                <a class="site-brand" href="{{ url('/') }}">
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
                        @foreach ($navItems as $item)
                            @if (!empty($item['children']))
                                @include('partials.services-dropdown', ['serviceLinks' => $item['children']])
                            @else
                                <a
                                    class="site-nav__link"
                                    href="{{ $item['href'] }}"
                                    @if (!empty($item['anchor'])) data-nav-link @endif
                                >
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </nav>

                    <div class="site-header__actions">
                        @include('partials.public-auth-actions')
                    </div>
                </div>
            </div>
        </header>

        <main class="home-main">
            <section class="home-hero" id="home" data-section="home">
                <div class="site-container">
                    <div class="home-hero-slider" data-hero-slider data-parallax data-reveal>
                        @foreach ($heroSlides as $slide)
                            <article
                                class="home-hero-slide{{ $loop->first ? ' is-active' : '' }}"
                                data-hero-slide
                                aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                            >
                                <div class="home-hero-slide__media" aria-hidden="true">
                                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }} {{ $slide['highlight'] }} {{ $slide['title_end'] }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                                </div>
                                <div class="home-hero-slide__overlay"></div>

                                <div class="home-hero-slide__content">
                                    <div class="home-hero-slide__copy">
                                        <span class="section-chip">{{ $slide['eyebrow'] }}</span>
                                        <h1>
                                            <span class="home-hero-slide__headline-main">{{ $slide['title'] }}</span>
                                            <span class="home-hero-slide__headline-highlight">{{ $slide['highlight'] }}</span>
                                            <span class="home-hero-slide__headline-end">{{ $slide['title_end'] }}</span>
                                        </h1>
                                        <p>{{ $slide['copy'] }}</p>

                                        <div class="hero-actions">
                                            @guest
                                                <a class="site-button site-button--large" href="{{ route('register') }}">
                                                    <span>Get Started</span>
                                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            @else
                                                <a class="site-button site-button--large" href="{{ route('dashboard') }}">
                                                    <span>Open Dashboard</span>
                                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            @endguest

                                            <a class="site-button site-button--soft site-button--large" href="{{ route('features') }}">
                                                <span>Explore Features</span>
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="home-hero-slide__cards">
                                        @foreach ($slide['metrics'] as $metric)
                                            <article class="home-hero__metric">
                                                <span class="home-hero__metric-icon">
                                                    @if ($metric['icon'] === 'crop' || $metric['icon'] === 'soil' || $metric['icon'] === 'leaf')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                                            <path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                        </svg>
                                                    @elseif ($metric['icon'] === 'weather' || $metric['icon'] === 'cloud')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    @elseif ($metric['icon'] === 'yield' || $metric['icon'] === 'data')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                        </svg>
                                                    @elseif ($metric['icon'] === 'drop' || $metric['icon'] === 'water')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M12 4.8c-3.4 3.8-5.2 6.7-5.2 9.2a5.2 5.2 0 1 0 10.4 0c0-2.5-1.8-5.4-5.2-9.2Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                        </svg>
                                                    @elseif ($metric['icon'] === 'shield')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M12 3.8 18 6v5.5c0 4-2.5 7.3-6 8.7-3.5-1.4-6-4.7-6-8.7V6l6-2.2Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                            <path d="m9.5 12.2 1.7 1.8 3.5-3.7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                        </svg>
                                                    @elseif ($metric['icon'] === 'clock')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M12 7v5l3 3M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    @elseif ($metric['icon'] === 'bell')
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M6 16h12l-1.4-1.6V10a4.6 4.6 0 1 0-9.2 0v4.4L6 16ZM10.2 18a1.8 1.8 0 0 0 3.6 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    @else
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M4 6h16M6 12h12M8 18h8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                        </svg>
                                                    @endif
                                                </span>
                                                <div>
                                                    <small>{{ $metric['label'] }}</small>
                                                    <strong>{{ $metric['value'] }}</strong>
                                                    @if ($metric['detail'])
                                                        <p>{{ $metric['detail'] }}</p>
                                                    @endif
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        <div class="home-hero-slider__controls" aria-label="Hero slider controls">
                            <button class="home-hero-slider__arrow" type="button" data-hero-prev aria-label="Previous slide">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="m15 5-7 7 7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>

                            <div class="home-hero-slider__dots">
                                @foreach ($heroSlides as $slide)
                                    <button
                                        class="home-hero-slider__dot{{ $loop->first ? ' is-active' : '' }}"
                                        type="button"
                                        data-hero-dot
                                        data-hero-index="{{ $loop->index }}"
                                        aria-label="Go to slide {{ $loop->iteration }}"
                                        aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    ></button>
                                @endforeach
                            </div>

                            <button class="home-hero-slider__arrow" type="button" data-hero-next aria-label="Next slide">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="m9 5 7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="home-features" id="features" data-section="features">
                <div class="site-container">
                    <div class="section-heading home-section-heading" data-reveal>
                        <span class="section-chip section-chip--soft">Our Features</span>
                        <h2>Smart Farming Tools at a Glance</h2>
                        <div class="section-divider"></div>
                    </div>

                    <div class="home-features__grid">
                        @foreach ($featureCards as $feature)
                            <article class="home-feature-card" data-reveal>
                                <span class="home-feature-card__icon">
                                    @if ($feature['icon'] === 'crop')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                            <path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($feature['icon'] === 'yield')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4 19h16M7 15v-5M12 15V7M17 15v-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($feature['icon'] === 'disease')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M10.5 17a6.5 6.5 0 1 1 4.6-11.1A6.5 6.5 0 0 1 10.5 17Zm4.8-1.1L20 20.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                            <path d="m8.7 10.7 1.5 1.5 3.1-3.1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($feature['icon'] === 'fertilizer')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M8 4h8v4h3v4c0 4-2.9 7.4-7 8-4.1-.6-7-4-7-8V8h3V4Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                            <path d="M12 9v6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @elseif ($feature['icon'] === 'weather')
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18 4.5v2.4M21 7.2h-2.4M15 7.2h-2.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4.5 5.5h15v13h-15zM8 9h8M8 13h5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </span>
                                <h3>{{ $feature['title'] }}</h3>
                                <p>{{ $feature['copy'] }}</p>
                                <a href="{{ route('features') }}">
                                    <span>View Details</span>
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="home-long-intro" data-section="platform">
                <div class="site-container">
                    <div class="home-long-intro__grid">
                        <div class="home-long-intro__copy" data-reveal>
                            <span class="section-chip section-chip--soft">Complete AgroVision Platform</span>
                            <h2>One long farming workflow from field input to final report</h2>
                            <p>
                                AgroVision is built for farmers who need clear decisions, not confusing dashboards. The system connects location search, live weather, manual soil inputs, crop planning, yield estimation, fertilizer guidance, image-based disease detection, and farm reports into one Laravel-powered web platform.
                            </p>
                            <p>
                                Every feature is designed around real farm questions: Which crop should I grow? How much yield can I expect? Which fertilizer should I apply? What is today&apos;s weather risk? What disease is visible on this leaf? Which reports did I generate this season?
                            </p>
                            <div class="home-long-intro__actions">
                                @guest
                                    <a class="site-button" href="{{ route('register') }}">Create Farmer Account</a>
                                @else
                                    <a class="site-button" href="{{ route('dashboard') }}">Open Dashboard</a>
                                @endguest
                                <a class="site-button site-button--soft" href="#agrovision-modules">View Modules</a>
                            </div>
                        </div>

                        <div class="home-long-intro__media" data-reveal>
                            <img src="{{ $images['tablet'] }}" alt="Farmer using digital farming tools in a field">
                            <div class="home-long-intro__panel">
                                <strong>Live field profile</strong>
                                <span>Location, weather, soil, crop, nutrients, and report history stay connected.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="home-platform-sections">
                <div class="site-container">
                    @foreach ($platformSections as $section)
                        <article class="home-platform-row{{ $loop->even ? ' home-platform-row--reverse' : '' }}" data-reveal>
                            <div class="home-platform-row__image">
                                <img src="{{ $section['image'] }}" alt="{{ $section['title'] }}">
                            </div>
                            <div class="home-platform-row__content">
                                <span class="section-chip section-chip--soft">{{ $section['eyebrow'] }}</span>
                                <h2>{{ $section['title'] }}</h2>
                                <p>{{ $section['copy'] }}</p>
                                <ul>
                                    @foreach ($section['points'] as $point)
                                        <li>{{ $point }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="home-module-showcase" id="agrovision-modules">
                <div class="site-container">
                    <div class="section-heading home-section-heading" data-reveal>
                        <span class="section-chip section-chip--soft">Dashboard Modules</span>
                        <h2>Long-form smart farming features built into the user dashboard</h2>
                        <div class="section-divider"></div>
                    </div>

                    <div class="home-module-showcase__grid">
                        @foreach ($moduleShowcase as $module)
                            <article class="home-module-card" data-reveal>
                                <img src="{{ $module['image'] }}" alt="{{ $module['label'] }}">
                                <div>
                                    <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3>{{ $module['label'] }}</h3>
                                    <p>{{ $module['copy'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="home-journey">
                <div class="site-container">
                    <div class="home-journey__header" data-reveal>
                        <span class="section-chip section-chip--soft">How It Works</span>
                        <h2>From a village name to a saved farm report</h2>
                        <p>AgroVision keeps the farmer journey simple while still saving structured data for future analysis, admin review, and seasonal reporting.</p>
                    </div>

                    <div class="home-journey__steps">
                        @foreach ($journeySteps as $step)
                            <article class="home-journey-step" data-reveal>
                                <span>{{ $step['step'] }}</span>
                                <h3>{{ $step['title'] }}</h3>
                                <p>{{ $step['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="home-report-panel">
                <div class="site-container">
                    <div class="home-report-panel__grid">
                        <div class="home-report-panel__content" data-reveal>
                            <span class="section-chip section-chip--soft">Farm Reports & Admin Panel</span>
                            <h2>Reports stay inside your own database</h2>
                            <p>
                                Farm Reports are intentionally database-only. Google helps with location and weather where useful, but reporting is built from saved AgroVision records so every farmer can review their own history securely.
                            </p>
                            <div class="home-report-panel__list">
                                @foreach ($reportHighlights as $highlight)
                                    <div>{{ $highlight }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="home-report-panel__visual" data-reveal>
                            <img src="{{ $images['fieldRows'] }}" alt="Agriculture field rows for farm report analysis">
                            <div class="home-report-panel__stats">
                                <article><strong>5</strong><span>Report Sources</span></article>
                                <article><strong>PDF</strong><span>Download</span></article>
                                <article><strong>CSV</strong><span>Export</span></article>
                                <article><strong>Admin</strong><span>Full View</span></article>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="home-blog-long">
                <div class="site-container">
                    <div class="section-heading home-section-heading" data-reveal>
                        <span class="section-chip section-chip--soft">Learning Hub</span>
                        <h2>Useful farming topics for AgroVision users</h2>
                        <div class="section-divider"></div>
                    </div>

                    <div class="home-blog-long__grid">
                        @foreach ($articles as $article)
                            <article class="home-blog-long-card" data-reveal>
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                                <div>
                                    <span>{{ $article['date'] }}</span>
                                    <h3>{{ $article['title'] }}</h3>
                                    <p>Practical guidance connected to soil health, irrigation planning, disease prevention, and weather-aware farm decisions.</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="home-faq">
                <div class="site-container">
                    <div class="home-faq__grid">
                        <div class="home-faq__intro" data-reveal>
                            <span class="section-chip section-chip--soft">Important Notes</span>
                            <h2>Clear API rules for the project</h2>
                            <p>These rules keep AgroVision accurate and honest: use Google where it is useful, keep soil manual, keep reports local, and keep disease detection image-based.</p>
                        </div>
                        <div class="home-faq__items">
                            @foreach ($faqItems as $item)
                                <article data-reveal>
                                    <h3>{{ $item['question'] }}</h3>
                                    <p>{{ $item['answer'] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="agro-long-section agro-long-section--alt">
                <div class="site-container">
                    <div class="agro-long-section__header" data-reveal>
                        <span class="section-chip section-chip--soft">Built For Himachal Farms</span>
                        <h2>A complete smart farming journey from location to final report.</h2>
                        <p>AgroVision supports hilly fields, changing weather, mixed crops, and seasonal decisions. Every module explains what it needs, why it needs it, and what result the farmer receives.</p>
                    </div>

                    <div class="agro-long-grid" data-reveal>
                        <article class="agro-long-card">
                            <strong>Location-first workflow</strong>
                            <p>Farmers select their village, town, or field area. AgroVision stores the selected place with latitude and longitude so weather, crop planning, yield estimates, fertilizer guidance, and reports stay connected to the right farm context.</p>
                            <ul>
                                <li>Useful for district-wise and village-wise records.</li>
                                <li>Helps compare recommendations across locations.</li>
                                <li>Keeps reports searchable by location.</li>
                            </ul>
                        </article>
                        <article class="agro-long-card">
                            <strong>Manual soil truth</strong>
                            <p>Soil type remains manual because Google APIs cannot confirm exact Loamy, Sandy, Clay, Black, or Alluvial soil. Farmers can save soil profiles once and reuse them in yield and fertilizer modules.</p>
                            <ul>
                                <li>Supports pH, NPK, moisture, organic carbon, and texture.</li>
                                <li>Stores a snapshot with each prediction.</li>
                                <li>Admin can verify soil entries later.</li>
                            </ul>
                        </article>
                        <article class="agro-long-card">
                            <strong>Reports farmers can trust</strong>
                            <p>Every recommendation is saved in MySQL under the logged-in user. The farmer sees only their own records, while the admin panel can review both input and result details for all modules.</p>
                            <ul>
                                <li>Crop, yield, disease, fertilizer, weather, and soil reports.</li>
                                <li>Filters by feature, crop, location, and date.</li>
                                <li>Export-ready records for farm documentation.</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer site-footer--home" id="contact" data-section="contact">
            <div class="site-container site-footer__main site-footer__main--home">
                <div class="site-footer__brand">
                    <a class="site-brand site-brand--footer" href="{{ url('/') }}">
                        <span class="site-brand__mark">
                            <svg viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/>
                            </svg>
                        </span>
                        <span class="site-brand__copy">
                            <strong>{{ $brandName }}</strong>
                            <small>Smart Crop Monitoring &amp; Yield Prediction System</small>
                        </span>
                    </a>

                    <p class="site-footer__brand-copy">
                        An AI based platform to support farmers with smart analytics and predictions.
                    </p>

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
                        <a href="#contact" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="#contact" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/>
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
                    <h3>Contact Us</h3>
                    <ul class="site-footer__contact">
                        <li>AgroVision Smart Farming Project, Himachal Pradesh, India</li>
                        <li><a href="tel:+917018741392">+91 70187 41392</a></li>
                        <li><a href="mailto:info@agrovision.com">info@agrovision.com</a></li>
                    </ul>
                </div>
            </div>

            <div class="site-footer__bottom">
                <div class="site-container site-footer__bottom-inner">
                    <p>&copy; {{ now()->year }} {{ $brandName }}. All Rights Reserved.</p>
                    <div>
                        <a href="#contact">Privacy Policy</a>
                        <a href="#contact">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>

        @include('partials.chat-widget')

        <a class="site-backtotop" href="#home" data-backtotop aria-label="Back to top">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m7 14 5-5 5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <script src="{{ asset('js/home-page.js') }}" defer></script>
        <script src="{{ asset('js/chat-widget.js') }}" defer></script>
    </body>
</html>
