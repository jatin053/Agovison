@extends('layouts.app')

@php($pageTitle = 'Weather Intelligence')
@php($pageSubtitle = 'Monitor climate signals, market movement, and field activity from one weather-aware command panel.')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="surface-card h-100" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <span class="hero-badge"><i class="fa-solid fa-satellite"></i> Hyper-local climate intelligence</span>
                        <h3 class="mt-3 mb-1">{{ $location }}</h3>
                        <p class="muted-label mb-0">Use these conditions to plan irrigation, spraying, labor windows, and crop protection.</p>
                    </div>
                    <form action="{{ route('weather.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="location" class="form-control" placeholder="Search city" value="{{ $location }}">
                        <button class="btn btn-success">Update</button>
                    </form>
                </div>
                <div class="dashboard-grid">
                    <div class="metric-card">
                        <h6>Temperature</h6>
                        <div class="metric-value">{{ number_format((float) $weather['temperature'], 1) }} C</div>
                        <div class="metric-trend">{{ $weather['condition'] }}</div>
                    </div>
                    <div class="metric-card">
                        <h6>Humidity</h6>
                        <div class="metric-value">{{ number_format((float) $weather['humidity'], 0) }}%</div>
                        <div class="metric-trend">Disease pressure indicator</div>
                    </div>
                    <div class="metric-card">
                        <h6>Rain prediction</h6>
                        <div class="metric-value">{{ number_format((float) $weather['rain_prediction'], 0) }}%</div>
                        <div class="metric-trend">Schedule spraying accordingly</div>
                    </div>
                    <div class="metric-card">
                        <h6>Wind speed</h6>
                        <div class="metric-value">{{ number_format((float) $weather['wind_speed'], 0) }} km/h</div>
                        <div class="metric-trend">Field operation timing</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="surface-card h-100" data-aos="fade-up">
                <h3 class="mb-3">Recommended actions</h3>
                <ul class="insight-list mb-0">
                    <li>Plan irrigation in low-wind morning hours for higher water-use efficiency.</li>
                    <li>If humidity stays high, monitor fungal pressure in dense crop canopies.</li>
                    <li>Use mandi price cards alongside weather to decide harvest dispatch timing.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="surface-card h-100" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1">Live mandi signals</h3>
                        <p class="muted-label mb-0">Market-aware weather planning for harvest and dispatch.</p>
                    </div>
                </div>
                <div class="metric-stack">
                    @foreach($marketPrices as $price)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $price['crop'] }}</strong>
                                <span class="signal-chip {{ $price['trend'] }}">{{ $price['change'] }}%</span>
                            </div>
                            <div class="muted-label mt-2">{{ $price['market'] }}</div>
                            <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="surface-card h-100" data-aos="fade-up">
                <h3 class="mb-3">Community and auction activity</h3>
                <div class="metric-stack">
                    @foreach($communityHighlights as $post)
                        <div class="feed-card p-3">
                            <div class="muted-label">{{ $post->user->name }}</div>
                            <h5 class="mb-2">{{ $post->title ?: 'Farmer update' }}</h5>
                            <p class="mb-0 muted-label">{{ \Illuminate\Support\Str::limit($post->body, 90) }}</p>
                        </div>
                    @endforeach
                    @foreach($liveAuctions as $auction)
                        <div class="auction-card p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="muted-label">{{ $auction->farmer->name }}</div>
                                    <strong>{{ $auction->title }}</strong>
                                </div>
                                <span class="countdown" data-countdown="{{ $auction->ends_at?->toIso8601String() }}"></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
