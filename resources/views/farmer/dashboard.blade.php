@extends('layouts.app')

@php($pageTitle = 'Farmer Dashboard')
@php($pageSubtitle = 'Manage crop inventory, monitor sales, stay ahead of weather and irrigation risks, and activate AI recommendations.')

@section('content')
    <div class="row g-4 mb-4">
        @foreach($analytics['totals'] as $label => $value)
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <h6>{{ str_replace('_', ' ', ucfirst($label)) }}</h6>
                    <div class="metric-value" data-countup="{{ (int) $value }}" @if($label === 'revenue') data-countup-format="currency" @endif>
                        {{ number_format($value, 2) }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="surface-card chart-card">
                <h4 class="mb-4">Sales analytics</h4>
                <canvas id="farmerSalesChart"></canvas>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="surface-card">
                <h4 class="mb-3">Latest weather</h4>
                <div class="metric-value">{{ number_format((float) $latestWeather->temperature, 1) }} C</div>
                <div class="muted-label">Humidity {{ number_format((float) $latestWeather->humidity, 1) }}% • Wind {{ number_format((float) $latestWeather->wind_speed, 1) }} km/h</div>
                <div class="badge-soft mt-3">{{ $latestWeather->condition }}</div>
                <a href="{{ route('farmer.intelligence.index') }}" class="btn btn-success btn-sm mt-4">Open AI Intelligence</a>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-xl-5">
            <div class="surface-card h-100">
                <h4 class="mb-3">Irrigation snapshot</h4>
                @if($irrigationInsight && $latestSoilReport)
                    <span class="badge-soft mb-3">{{ ucfirst($irrigationInsight['status']) }}</span>
                    <h5>{{ $irrigationInsight['headline'] }}</h5>
                    <div class="progress-soft my-3"><span style="width: {{ $irrigationInsight['efficiency_score'] }}%"></span></div>
                    <div class="small muted-label mb-3">Moisture {{ number_format((float) $latestSoilReport->moisture_percentage, 0) }}% • Water {{ number_format((float) $latestSoilReport->water_level_percentage, 0) }}%</div>
                    <ul class="insight-list mb-0">
                        @foreach($irrigationInsight['actions'] as $action)
                            <li>{{ $action }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="muted-label">Create a soil report in the AI Intelligence Hub to unlock irrigation recommendations.</p>
                @endif
            </div>
        </div>
        <div class="col-xl-7">
            <div class="surface-card h-100">
                <h4 class="mb-3">Mandi and auction overview</h4>
                <div class="row g-3 mb-4">
                    @foreach($marketPrices as $price)
                        <div class="col-md-6">
                            <div class="mini-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $price['crop'] }}</strong>
                                    <span class="signal-chip {{ $price['trend'] }}">{{ $price['change'] }}%</span>
                                </div>
                                <div class="small muted-label mt-2">{{ $price['market'] }}</div>
                                <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="metric-stack">
                    @foreach($latestAuctions as $auction)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $auction->title }}</strong>
                                    <div class="small muted-label mt-2">{{ $auction->crop->title }} • {{ $auction->bids_count }} bids</div>
                                </div>
                                <div class="small">INR {{ number_format($auction->current_price, 0) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        new Chart(document.getElementById('farmerSalesChart'), {
            type: 'line',
            data: {
                labels: @json($analytics['sales']['labels']),
                datasets: [{ label: 'Revenue', data: @json($analytics['sales']['values']), borderColor: '#69e084', backgroundColor: 'rgba(105,224,132,.2)', fill: true, tension: 0.35 }]
            }
        });
    </script>
@endpush
