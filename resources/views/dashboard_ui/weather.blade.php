@extends('dashboard_ui.layout')

@section('title', 'Weather Forecast')
@section('subtitle', 'Fetch live farm weather by selected location and save it with your account.')

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Location Search</p>
                        <h2>Choose a farm location</h2>
                    </div>
                </div>

                <form class="dash-field-grid weather-location-form" method="POST" action="{{ route('dashboard.weather.store') }}">
                    @csrf
                    <div class="dash-field dash-field--full">
                        <span>Choose location method</span>
                        <div class="weather-location-actions">
                            <button class="dash-button dash-button--ghost" type="button"
                                    data-use-live-location
                                    data-location-target="location_name"
                                    data-reverse-location="{{ route('dashboard.location.reverse') }}">
                                Use My Live Location
                            </button>
                            <span>or enter it manually below</span>
                        </div>
                        <p class="dash-note" data-location-status>Allow browser location access for the most accurate local forecast.</p>
                    </div>

                    <label class="dash-field dash-field--full">
                        <span>City, village, district, or farm location</span>
                        <input class="dash-input" type="text" name="location_name" value="{{ old('location_name') }}" placeholder="Example: Mandi, Himachal Pradesh" required>
                        <input type="hidden" name="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" value="{{ old('longitude') }}">
                    </label>

                    <label class="dash-field dash-field--full">
                        <span>Forecast date</span>
                        <input class="dash-input" type="date" name="forecast_date"
                               min="{{ now()->toDateString() }}"
                               max="{{ now()->addDays(5)->toDateString() }}"
                               value="{{ old('forecast_date', now()->toDateString()) }}" required>
                        <small class="dash-note">Choose today or any available day in the next five days.</small>
                    </label>

                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">Get Weather Forecast</button>
                    </div>
                </form>
            </article>

            <article class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Forecast Result</p>
                        <h2>Current conditions</h2>
                    </div>
                </div>

                @if ($result)
                    <div class="dash-weather-panel">
                        <div class="dash-weather-panel__main">
                            <span class="dash-weather-panel__icon" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => 'weather-sun'])
                            </span>
                            <div>
                                <strong>{{ $result->temperature ?? 'N/A' }}&deg;C</strong>
                                <p>{{ $result->weather_condition ?? 'Condition unavailable' }}</p>
                                <small>{{ $result->location_name }}</small>
                                <small>{{ $result->forecast_date?->format('M d, Y') ?? 'Current conditions' }}</small>
                            </div>
                        </div>
                        <div class="dash-mini-grid dash-mini-grid--wide">
                            <article><strong>{{ $result->humidity ?? 'N/A' }}%</strong><span>Humidity</span></article>
                            <article><strong>{{ $result->rainfall ?? 'N/A' }}</strong><span>Rainfall</span></article>
                            <article><strong>{{ $result->wind_speed ?? 'N/A' }}</strong><span>Wind Speed</span></article>
                            <article><strong>{{ $result->cloud_cover ?? 'N/A' }}</strong><span>Cloud Cover</span></article>
                            <article><strong>{{ $result->air_quality_index ? $result->air_quality_index.' / 5' : 'N/A' }}</strong><span>OpenWeather AQI</span></article>
                            <article><strong>{{ $result->air_quality_category ?? 'N/A' }}</strong><span>Current Air Quality</span></article>
                        </div>
                        <div class="dash-highlight">
                            <strong>Farming Advice</strong>
                            <p>{{ $result->farming_advice }}</p>
                        </div>
                    </div>
                @else
                    <p class="dash-note">Search a location to save weather data and generate farming advice.</p>
                @endif
            </article>
        </section>

        @include('dashboard_ui.partials.recent-records', ['records' => $records, 'columns' => ['location_name' => 'Location', 'temperature' => 'Temp', 'humidity' => 'Humidity', 'weather_condition' => 'Condition']])
    </div>
@endsection

@push('scripts')
    @include('dashboard_ui.partials.feature-scripts')
@endpush
