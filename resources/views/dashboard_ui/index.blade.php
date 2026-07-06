@extends('dashboard_ui.layout')

@php
    $diseaseReports = auth()->user()?->diseaseDetections()->latest()->take(3)->get() ?? collect();
    $latestDisease = $diseaseReports->first();
    $totalDiseaseChecks = auth()->user()?->diseaseDetections()->count() ?? 0;
    $fertilizerReports = auth()->user()?->fertilizerRecommendations()->latest()->take(3)->get() ?? collect();
    $latestFertilizer = $fertilizerReports->first();
    $totalFertilizerRecommendations = auth()->user()?->fertilizerRecommendations()->count() ?? 0;
@endphp

@php
    $stats = [
        ['label' => 'Active Fields', 'value' => '12', 'delta' => '+2 this week', 'tone' => 'green', 'icon' => 'crop'],
        ['label' => 'Yield Forecasts', 'value' => '32.4', 'delta' => 'Quintal / acre', 'tone' => 'blue', 'icon' => 'yield'],
        ['label' => 'Disease Alerts', 'value' => '05', 'delta' => '2 need attention', 'tone' => 'orange', 'icon' => 'disease'],
        ['label' => 'Saved Reports', 'value' => '18', 'delta' => 'Ready to export', 'tone' => 'purple', 'icon' => 'reports'],
    ];

    $quickTools = [
        ['title' => 'Crop Recommendation', 'copy' => 'Match the best crop with soil and weather.', 'route' => route('dashboard.crop'), 'icon' => 'crop', 'tone' => 'green'],
        ['title' => 'Yield Prediction', 'copy' => 'Estimate yield using farm and climate data.', 'route' => route('dashboard.yield'), 'icon' => 'yield', 'tone' => 'blue'],
        ['title' => 'Disease Detection', 'copy' => 'Upload a crop or leaf image to identify a possible disease and receive basic treatment and prevention guidance.', 'route' => route('dashboard.disease'), 'icon' => 'disease', 'tone' => 'orange'],
        ['title' => 'Fertilizer Recommendation', 'copy' => 'Match crop stage, soil profile, NPK, pH, and symptoms with safe fertilizer guidance.', 'route' => route('dashboard.fertilizer'), 'icon' => 'fertilizer', 'tone' => 'orange'],
        ['title' => 'Weather Forecast', 'copy' => 'Plan irrigation and spraying with confidence.', 'route' => route('dashboard.weather'), 'icon' => 'weather', 'tone' => 'cyan'],
    ];

    $activities = [
        ['feature' => 'Yield Prediction', 'detail' => 'Wheat field 2.5 acres | Predicted 32.4 quintal/acre', 'time' => 'Today, 10:30 AM', 'status' => 'Completed'],
        ['feature' => 'Crop Recommendation', 'detail' => 'Loamy soil | Recommended Paddy (Rice)', 'time' => 'Today, 08:15 AM', 'status' => 'High Match'],
        ['feature' => 'Disease Detection', 'detail' => 'Tomato leaf scan | Early blight flagged', 'time' => 'Yesterday, 04:20 PM', 'status' => 'Needs Attention'],
        ['feature' => 'Weather Forecast', 'detail' => 'Chandigarh | Light rain expected tomorrow', 'time' => 'Yesterday, 11:45 AM', 'status' => 'Updated'],
    ];
@endphp

@section('title', 'Dashboard')
@section('subtitle', 'Your farm workspace with live insights, planning tools, and activity in one consistent view.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.reports') }}">View Reports</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.crop') }}">Open Smart Tools</a>
@endsection

@section('content')
    <div class="dash-content-stack">
        <section class="dash-grid dash-grid--4">
            @foreach ($stats as $stat)
                <article class="dash-card dash-card--metric dash-tone-{{ $stat['tone'] }}">
                    <div class="dash-metric">
                        <span class="dash-metric__icon" aria-hidden="true">
                            @include('dashboard_ui.partials.icon', ['icon' => $stat['icon']])
                        </span>
                        <div>
                            <p>{{ $stat['label'] }}</p>
                            <h2>{{ $stat['value'] }}</h2>
                            <small>{{ $stat['delta'] }}</small>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="dash-card dash-card--soft-green">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Disease Detection</p>
                    <h2>Upload a crop or leaf image to identify a possible disease and receive basic treatment and prevention guidance.</h2>
                </div>
                <span class="dash-badge dash-badge--green">{{ $totalDiseaseChecks }} Total Disease Checks</span>
            </div>

            <div class="dash-grid dash-grid--2">
                <div class="dash-highlight">
                    <strong>Latest Disease Result</strong>
                    @if ($latestDisease)
                        <p>{{ $latestDisease->crop_name }} - {{ $latestDisease->disease_name }} ({{ number_format((float) $latestDisease->confidence, 2) }}%)</p>
                        <p>{{ $latestDisease->status }}</p>
                    @else
                        <p>No disease report has been saved yet.</p>
                    @endif
                    <div class="dash-button-row">
                        <a class="dash-button dash-button--primary" href="{{ route('dashboard.disease') }}">Detect Disease</a>
                        <a class="dash-button dash-button--ghost" href="{{ route('dashboard.disease.history') }}">View History</a>
                    </div>
                </div>

                <div class="dash-list">
                    <p class="dash-eyebrow">Recent Disease Reports</p>
                    @forelse ($diseaseReports as $report)
                        <div class="dash-list__item">
                            <div>
                                <strong>{{ $report->crop_name }} - {{ $report->disease_name }}</strong>
                                <p>{{ $report->location }} | {{ $report->created_at?->format('M d, Y') }}</p>
                            </div>
                            <span class="dash-badge {{ $report->confidence >= 85 ? 'dash-badge--green' : ($report->confidence >= 60 ? 'dash-badge--orange' : 'dash-badge--blue') }}">{{ number_format((float) $report->confidence, 2) }}%</span>
                        </div>
                    @empty
                        <p class="dash-note">Recent disease reports will appear here after the first scan.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="dash-card dash-card--soft-amber">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Fertilizer Recommendation</p>
                    <h2>Use soil profile, NPK, crop stage, problem symptoms, and weather timing to choose fertilizer more carefully.</h2>
                </div>
                <span class="dash-badge dash-badge--orange">{{ $totalFertilizerRecommendations }} Total Fertilizer Reports</span>
            </div>

            <div class="dash-grid dash-grid--2">
                <div class="dash-highlight">
                    <strong>Latest Fertilizer Result</strong>
                    @if ($latestFertilizer)
                        <p>{{ $latestFertilizer->crop_name }} - {{ $latestFertilizer->recommended_fertilizer_name ?: $latestFertilizer->recommended_fertilizer }}</p>
                        <p>{{ $latestFertilizer->status ?: 'Saved recommendation' }}</p>
                    @else
                        <p>No fertilizer recommendation has been saved yet.</p>
                    @endif
                    <div class="dash-button-row">
                        <a class="dash-button dash-button--primary" href="{{ route('dashboard.fertilizer') }}">Get Recommendation</a>
                        <a class="dash-button dash-button--ghost" href="{{ route('dashboard.fertilizer.history') }}">View History</a>
                    </div>
                </div>

                <div class="dash-list">
                    <p class="dash-eyebrow">Recent Fertilizer Reports</p>
                    @forelse ($fertilizerReports as $report)
                        <div class="dash-list__item">
                            <div>
                                <strong>{{ $report->crop_name }} - {{ $report->recommended_fertilizer_name ?: $report->recommended_fertilizer }}</strong>
                                <p>{{ $report->location ?: $report->location_name ?: 'No location' }} | {{ $report->created_at?->format('M d, Y') }}</p>
                            </div>
                            <span class="dash-badge {{ $report->confidence >= 85 ? 'dash-badge--green' : ($report->confidence >= 60 ? 'dash-badge--orange' : 'dash-badge--blue') }}">{{ $report->confidence ? number_format((float) $report->confidence, 0).'%' : 'Saved' }}</span>
                        </div>
                    @empty
                        <p class="dash-note">Recent fertilizer reports will appear here after the first recommendation.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="dash-grid dash-grid--hero">
            <article class="dash-card dash-feature-hero">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Farm Pulse</p>
                        <h2>Today looks healthy across most fields.</h2>
                    </div>
                    <span class="dash-badge dash-badge--green">Stable Conditions</span>
                </div>

                <div class="dash-feature-hero__grid">
                    <div class="dash-feature-hero__summary">
                        <p>Weather, moisture, and crop suitability are aligned for this week. Focus on tomato disease monitoring and complete the pending fertilizer recommendation for the north plot.</p>
                        <div class="dash-inline-metrics">
                            <div class="dash-inline-metric">
                                <strong>92%</strong>
                                <span>Crop match confidence</span>
                            </div>
                            <div class="dash-inline-metric">
                                <strong>24&deg;C</strong>
                                <span>Current weather</span>
                            </div>
                            <div class="dash-inline-metric">
                                <strong>62%</strong>
                                <span>Soil moisture</span>
                            </div>
                        </div>
                    </div>

                    <div class="dash-chart-card">
                        <div class="dash-chart-card__header">
                            <span>Weekly performance</span>
                            <strong>+16%</strong>
                        </div>
                        <div class="dash-bars">
                            <span style="height: 42%"></span>
                            <span style="height: 58%"></span>
                            <span style="height: 50%"></span>
                            <span style="height: 74%"></span>
                            <span style="height: 68%"></span>
                            <span style="height: 84%"></span>
                            <span style="height: 92%"></span>
                        </div>
                        <div class="dash-bars__labels">
                            <span>Mon</span>
                            <span>Tue</span>
                            <span>Wed</span>
                            <span>Thu</span>
                            <span>Fri</span>
                            <span>Sat</span>
                            <span>Sun</span>
                        </div>
                    </div>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Attention</p>
                        <h2>Priority queue</h2>
                    </div>
                </div>

                <div class="dash-list">
                    <div class="dash-list__item">
                        <div>
                            <strong>Tomato plot disease check</strong>
                            <p>2 leaves flagged for early blight in the latest scan.</p>
                        </div>
                        <span class="dash-badge dash-badge--orange">Needs Attention</span>
                    </div>
                    <div class="dash-list__item">
                        <div>
                            <strong>North field fertilizer plan</strong>
                            <p>Recommendation is ready to review before the next irrigation cycle.</p>
                        </div>
                        <span class="dash-badge dash-badge--blue">Ready</span>
                    </div>
                    <div class="dash-list__item">
                        <div>
                            <strong>Rain advisory</strong>
                            <p>Light rain expected tomorrow evening. Delay spray after 4 PM.</p>
                        </div>
                        <span class="dash-badge dash-badge--green">Weather Safe</span>
                    </div>
                </div>
            </article>
        </section>

        <section class="dash-grid dash-grid--2-1">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Quick Access</p>
                        <h2>Smart tool shortcuts</h2>
                    </div>
                </div>

                <div class="dash-tool-grid">
                    @foreach ($quickTools as $tool)
                        <a class="dash-tool-card dash-tone-{{ $tool['tone'] }}" href="{{ $tool['route'] }}">
                            <span class="dash-tool-card__icon" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => $tool['icon']])
                            </span>
                            <strong>{{ $tool['title'] }}</strong>
                            <p>{{ $tool['copy'] }}</p>
                        </a>
                    @endforeach
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Weather</p>
                        <h2>Current farm outlook</h2>
                    </div>
                </div>

                <div class="dash-weather-panel">
                    <div class="dash-weather-panel__main">
                        <span class="dash-weather-panel__icon" aria-hidden="true">
                            @include('dashboard_ui.partials.icon', ['icon' => 'weather-sun'])
                        </span>
                        <div>
                            <strong>24&deg;C</strong>
                            <p>Partly Cloudy</p>
                            <small>Chandigarh, India</small>
                        </div>
                    </div>

                    <div class="dash-mini-grid">
                        <article>
                            <strong>56%</strong>
                            <span>Humidity</span>
                        </article>
                        <article>
                            <strong>0.2 mm</strong>
                            <span>Rainfall</span>
                        </article>
                        <article>
                            <strong>12 km/h</strong>
                            <span>Wind</span>
                        </article>
                        <article>
                            <strong>5</strong>
                            <span>UV Index</span>
                        </article>
                    </div>
                </div>
            </article>
        </section>

        <section class="dash-grid dash-grid--2-1">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Recent Activity</p>
                        <h2>Latest farm actions</h2>
                    </div>
                    <a class="dash-text-link" href="{{ route('dashboard.history') }}">Open history</a>
                </div>

                <div class="dash-table-wrap">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Feature</th>
                                <th>Details</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity['feature'] }}</td>
                                    <td>{{ $activity['detail'] }}</td>
                                    <td>{{ $activity['time'] }}</td>
                                    <td><span class="dash-badge dash-badge--soft">{{ $activity['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Plan</p>
                        <h2>Next field steps</h2>
                    </div>
                </div>

                <div class="dash-steps">
                    <div class="dash-step">
                        <span>1</span>
                        <div>
                            <strong>Review crop recommendation</strong>
                            <p>Confirm paddy suitability for the south block.</p>
                        </div>
                    </div>
                    <div class="dash-step">
                        <span>2</span>
                        <div>
                            <strong>Inspect disease alerts</strong>
                            <p>Remove infected leaves and schedule the next scan.</p>
                        </div>
                    </div>
                    <div class="dash-step">
                        <span>3</span>
                        <div>
                            <strong>Export weekly report</strong>
                            <p>Share the updated summary with the farm manager.</p>
                        </div>
                    </div>
                </div>
            </article>
        </section>
    </div>
@endsection
