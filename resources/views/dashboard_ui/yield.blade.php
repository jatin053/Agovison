@extends('dashboard_ui.layout')

@section('title', 'Yield Prediction')
@section('subtitle', 'Estimate expected production using crop, land, season, soil, irrigation, and live weather data.')

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Input Details</p>
                        <h2>Predict expected yield</h2>
                    </div>
                </div>

                <form class="dash-field-grid" method="POST" action="{{ route('dashboard.yield.store') }}">
                    @csrf
                    <input type="hidden" name="soil_mode" value="saved">
                    <label class="dash-field dash-field--full">
                        <span>Saved Soil Scan (Optional)</span>
                        <select class="dash-select" name="soil_profile_id" data-soil-profile-select>
                            <option value="">Choose a scan, or select soil type manually below</option>
                            @foreach ($soilProfiles as $profile)
                                <option
                                    value="{{ $profile->id }}"
                                    data-soil-type="{{ $profile->soil_type }}"
                                    @selected((string) old('soil_profile_id', $selectedSoilProfile) === (string) $profile->id)
                                >{{ $profile->soil_type }} | {{ $profile->crop_name ?: 'Crop not recorded' }} | {{ $profile->created_at?->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                        <small class="dash-note">A saved photo scan fills the detected soil type. Soil chemistry requires a laboratory test and is not used in this yield estimate.</small>
                    </label>
                    <label class="dash-field">
                        <span>Crop Name</span>
                        <input class="dash-input" name="crop_name" value="{{ old('crop_name') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Season</span>
                        <select class="dash-select" name="season" required>
                            @foreach (['Kharif', 'Rabi', 'Summer', 'Winter', 'Monsoon'] as $season)
                                <option @selected(old('season') === $season)>{{ $season }}</option>
                            @endforeach
                        </select>
                    </label>
                    @include('dashboard_ui.partials.location-weather-fields')
                    <label class="dash-field">
                        <span>Land Area</span>
                        <input class="dash-input" type="number" step="0.01" min="0.01" name="land_area" value="{{ old('land_area') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Area Unit</span>
                        <select class="dash-select" name="area_unit" required>
                            @foreach (['Acre', 'Hectare', 'Bigha'] as $unit)
                                <option @selected(old('area_unit') === $unit)>{{ $unit }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Soil Type</span>
                        <select class="dash-select" name="soil_type" data-profile-soil-type>
                            @foreach (['Alluvial Soil', 'Black Soil', 'Cinder Soil', 'Clayey Soil', 'Laterite Soil', 'Loamy Soil', 'Peat Soil', 'Sandy Loam', 'Sandy Soil', 'Yellow Soil', 'Other'] as $soil)
                                <option @selected(old('soil_type') === $soil)>{{ $soil }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Irrigation Type</span>
                        <select class="dash-select" name="irrigation_type" required>
                            @foreach (['Canal', 'Drip', 'Sprinkler', 'Rainfed', 'Tube Well'] as $type)
                                <option @selected(old('irrigation_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Previous Crop Optional</span>
                        <input class="dash-input" name="previous_crop" value="{{ old('previous_crop') }}">
                    </label>
                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">Predict Yield</button>
                    </div>
                </form>
            </article>

            <article class="dash-card dash-card--soft-green yield-result-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Prediction Result</p>
                        <h2>Expected production</h2>
                    </div>
                </div>

                @if ($result)
                    <div class="dash-yield-banner">
                        <div class="dash-yield-banner__value">
                            <p class="dash-label">Expected Yield</p>
                            <h3>{{ $result->expected_yield }} {{ $result->yield_unit }}</h3>
                            <span class="dash-badge {{ $result->expected_yield >= 4 ? 'dash-badge--green' : 'dash-badge--orange' }}">
                                {{ $result->yield_status }}
                            </span>
                        </div>
                        <div class="dash-yield-banner__explanation">
                            <strong>What this means</strong>
                            <p>This is the estimated total production for {{ $result->land_area }} {{ $result->area_unit }} of {{ $result->crop_name }} using the selected soil, irrigation, and current weather.</p>
                        </div>
                    </div>

                    <div class="yield-facts">
                        <div><span>Crop</span><strong>{{ $result->crop_name }}</strong></div>
                        <div><span>Field size</span><strong>{{ $result->land_area }} {{ $result->area_unit }}</strong></div>
                        <div><span>Location</span><strong>{{ $result->location_name }}</strong></div>
                        <div><span>Soil</span><strong>{{ data_get($result->soil_snapshot, 'soil_type', $result->soil_type) }}</strong></div>
                        <div><span>Weather</span><strong>{{ $result->temperature ?? 'N/A' }}&deg;C / {{ $result->humidity ?? 'N/A' }}% humidity</strong></div>
                        <div><span>Irrigation</span><strong>{{ $result->irrigation_type }}</strong></div>
                    </div>

                    <div class="dash-highlight yield-advice">
                        <strong>Brief recommendation</strong>
                        <p>{{ $result->advice }}</p>
                    </div>

                    <p class="dash-note yield-disclaimer">
                        Planning estimate only. Actual production varies with crop variety, pests, nutrients, field management, and changing weather.
                    </p>
                @else
                    <p class="dash-note">Submit the form to save a yield prediction.</p>
                @endif
            </article>
        </section>

        @include('dashboard_ui.partials.recent-records', ['records' => $records, 'columns' => ['crop_name' => 'Crop', 'location_name' => 'Location', 'expected_yield' => 'Expected Yield', 'yield_status' => 'Status']])
    </div>
@endsection

@push('scripts')
    @include('dashboard_ui.partials.feature-scripts')
    <script src="{{ asset('js/soil-profile-fill.js') }}" defer></script>
@endpush
