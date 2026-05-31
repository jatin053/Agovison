@extends('layouts.app')

@php($pageTitle = 'AI Intelligence Hub')
@php($pageSubtitle = 'Combine weather, soil, irrigation, and market signals to make better crop decisions.')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="surface-card h-100" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div>
                        <h3 class="mb-1">AI crop recommendation</h3>
                        <p class="muted-label mb-0">Get smart crop suggestions based on soil type, season, water reserves, moisture, and local weather.</p>
                    </div>
                    <span class="badge-soft">Decision engine</span>
                </div>
                <form action="{{ route('farmer.intelligence.recommend') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ $recommendationInput['location'] ?? auth()->user()->city }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Soil type</label>
                        <select name="soil_type" class="form-select" required>
                            @foreach(['loamy' => 'Loamy', 'clay' => 'Clay', 'sandy' => 'Sandy', 'black' => 'Black'] as $value => $label)
                                <option value="{{ $value }}" @selected(($recommendationInput['soil_type'] ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Season</label>
                        <select name="season" class="form-select" required>
                            @foreach(['kharif' => 'Kharif', 'rabi' => 'Rabi', 'zaid' => 'Zaid'] as $value => $label)
                                <option value="{{ $value }}" @selected(($recommendationInput['season'] ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Water level percentage</label>
                        <input type="number" name="water_level_percentage" class="form-control" value="{{ $recommendationInput['water_level_percentage'] ?? 60 }}" min="0" max="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Moisture percentage</label>
                        <input type="number" name="moisture_percentage" class="form-control" value="{{ $recommendationInput['moisture_percentage'] ?? 55 }}" min="0" max="100">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success btn-lg">Generate AI recommendation</button>
                    </div>
                </form>

                @if($recommendation)
                    <div class="mt-4">
                        <div class="insight-grid mb-4">
                            <div class="metric-card">
                                <h6>Soil profile</h6>
                                <div class="metric-value">{{ $recommendation['soil_type'] }}</div>
                                <div class="metric-trend">{{ $recommendation['season'] }} season</div>
                            </div>
                            <div class="metric-card">
                                <h6>Water headline</h6>
                                <div class="metric-value">{{ $recommendation['water_headline'] }}</div>
                            </div>
                        </div>
                        <div class="surface-card bg-transparent border-0 shadow-none p-0">
                            <h4 class="mb-3">Recommendation stack</h4>
                            <div class="metric-stack">
                                @foreach($recommendation['recommendations'] as $item)
                                    <div class="mini-card">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>{{ $item['name'] }}</strong>
                                            <span class="badge-soft">{{ $item['score'] }}% fit</span>
                                        </div>
                                        <p class="muted-label mt-2 mb-0">{{ $item['reason'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-4">
            <div class="surface-card h-100" data-aos="fade-up">
                <h3 class="mb-3">Latest weather</h3>
                <div class="metric-value">{{ number_format((float) $latestWeather->temperature, 1) }} C</div>
                <div class="muted-label">Humidity {{ number_format((float) $latestWeather->humidity, 0) }}% • Rain {{ number_format((float) $latestWeather->rain_prediction, 0) }}%</div>
                <div class="badge-soft mt-3">{{ $latestWeather->condition }}</div>
                <div class="metric-stack mt-4">
                    @foreach($marketPrices as $price)
                        <div class="mini-card">
                            <strong>{{ $price['crop'] }}</strong>
                            <div class="small muted-label mt-2">{{ $price['market'] }}</div>
                            <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="surface-card h-100" data-aos="fade-up">
                <h3 class="mb-3">Soil and irrigation report</h3>
                <form action="{{ route('farmer.soil-reports.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Crop</label>
                        <select name="crop_id" class="form-select">
                            <option value="">General field report</option>
                            @foreach($crops as $crop)
                                <option value="{{ $crop->id }}">{{ $crop->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Soil type</label>
                        <select name="soil_type" class="form-select" required>
                            <option value="loamy">Loamy</option>
                            <option value="clay">Clay</option>
                            <option value="sandy">Sandy</option>
                            <option value="black">Black</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Season</label>
                        <select name="season" class="form-select" required>
                            <option value="kharif">Kharif</option>
                            <option value="rabi">Rabi</option>
                            <option value="zaid">Zaid</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">pH</label>
                        <input type="number" step="0.01" name="ph" class="form-control" value="6.8" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nitrogen</label>
                        <input type="number" step="0.01" name="nitrogen" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phosphorus</label>
                        <input type="number" step="0.01" name="phosphorus" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Potassium</label>
                        <input type="number" step="0.01" name="potassium" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Moisture %</label>
                        <input type="number" step="0.01" name="moisture_percentage" class="form-control" value="58" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Water level %</label>
                        <input type="number" step="0.01" name="water_level_percentage" class="form-control" value="62" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success">Save soil report</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="surface-card h-100" data-aos="fade-up">
                <h3 class="mb-3">Latest irrigation insight</h3>
                @if($irrigationInsight && $latestSoilReport)
                    <span class="badge-soft mb-3">{{ ucfirst($irrigationInsight['status']) }}</span>
                    <h4>{{ $irrigationInsight['headline'] }}</h4>
                    <div class="progress-soft my-3"><span style="width: {{ $irrigationInsight['efficiency_score'] }}%"></span></div>
                    <div class="small muted-label mb-3">Efficiency score: {{ $irrigationInsight['efficiency_score'] }}/100</div>
                    <ul class="insight-list mb-4">
                        @foreach($irrigationInsight['actions'] as $action)
                            <li>{{ $action }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="muted-label">Create your first soil report to unlock irrigation insight cards.</p>
                @endif

                <h4 class="mb-3">Recent soil logs</h4>
                <div class="metric-stack">
                    @foreach($soilReports as $report)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ ucfirst($report->soil_type) }} / {{ ucfirst($report->season) }}</strong>
                                <span class="small muted-label">{{ optional($report->logged_at)->diffForHumans() }}</span>
                            </div>
                            <div class="small mt-2">Moisture {{ number_format((float) $report->moisture_percentage, 0) }}% • Water {{ number_format((float) $report->water_level_percentage, 0) }}%</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
