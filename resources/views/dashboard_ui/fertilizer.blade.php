@extends('dashboard_ui.layout')

@section('title', 'Fertilizer Recommendation')
@section('subtitle', 'Choose fertilizer using crop, soil, season, growth stage, NPK, pH, symptoms, and location weather.')

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Input Details</p>
                        <h2>Enter crop and nutrient profile</h2>
                    </div>
                </div>

                <form class="dash-field-grid" method="POST" action="{{ route('dashboard.fertilizer.store') }}">
                    @csrf
                    <label class="dash-field dash-field--full">
                        <span>Select Soil Information</span>
                        <select class="dash-select" name="soil_mode" data-soil-profile-mode>
                            <option value="manual">Enter Soil Manually</option>
                            <option value="saved" @selected($selectedSoilProfile)>Use Saved Soil Profile</option>
                            <option value="estimate">Estimate Soil From Location</option>
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Saved Soil Profile</span>
                        <select class="dash-select" name="soil_profile_id" data-soil-profile-select>
                            <option value="">Choose saved profile</option>
                            @foreach ($soilProfiles as $profile)
                                @php
                                    $levelValue = fn ($value, $level) => $value ?? match ($level) {
                                        'Low' => 30,
                                        'High' => 90,
                                        'Medium' => 60,
                                        default => null,
                                    };
                                @endphp
                                <option
                                    value="{{ $profile->id }}"
                                    data-soil-type="{{ $profile->soil_type }}"
                                    data-ph="{{ $profile->ph_value }}"
                                    data-nitrogen="{{ $levelValue($profile->nitrogen_value, $profile->nitrogen_level) }}"
                                    data-phosphorus="{{ $levelValue($profile->phosphorus_value, $profile->phosphorus_level) }}"
                                    data-potassium="{{ $levelValue($profile->potassium_value, $profile->potassium_level) }}"
                                    data-organic-carbon="{{ $profile->organic_carbon }}"
                                    data-moisture="{{ $profile->soil_moisture }}"
                                    @selected((string) old('soil_profile_id', $selectedSoilProfile) === (string) $profile->id)
                                >{{ $profile->soil_type }} | {{ $profile->location ?: 'No location' }} | {{ $profile->created_at?->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                        <small class="dash-note">Saved profiles load soil type, pH, and NPK values for recommendation.</small>
                    </label>
                    <label class="dash-field">
                        <span>Crop Name</span>
                        <input class="dash-input" name="crop_name" value="{{ old('crop_name') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Soil Type</span>
                        <select class="dash-select" name="soil_type" data-profile-soil-type>
                            @foreach (['Loamy', 'Clay', 'Sandy', 'Black Soil', 'Alluvial', 'Red Soil', 'Laterite Soil', 'Other'] as $soil)
                                <option @selected(old('soil_type') === $soil)>{{ $soil }}</option>
                            @endforeach
                        </select>
                    </label>
                    @include('dashboard_ui.partials.location-weather-fields', ['includeWeather' => false])
                    <label class="dash-field">
                        <span>Season</span>
                        <select class="dash-select" name="season" required>
                            @foreach (['Kharif', 'Rabi', 'Summer', 'Winter', 'Monsoon'] as $season)
                                <option @selected(old('season') === $season)>{{ $season }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Growth Stage</span>
                        <select class="dash-select" name="growth_stage" required>
                            @foreach (['Seedling', 'Vegetative', 'Flowering', 'Fruiting', 'Maturity'] as $stage)
                                <option @selected(old('growth_stage') === $stage)>{{ $stage }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Nitrogen Level</span>
                        <input class="dash-input" type="number" step="0.01" min="0" name="nitrogen_level" value="{{ old('nitrogen_level') }}" data-profile-nitrogen>
                    </label>
                    <label class="dash-field">
                        <span>Phosphorus Level</span>
                        <input class="dash-input" type="number" step="0.01" min="0" name="phosphorus_level" value="{{ old('phosphorus_level') }}" data-profile-phosphorus>
                    </label>
                    <label class="dash-field">
                        <span>Potassium Level</span>
                        <input class="dash-input" type="number" step="0.01" min="0" name="potassium_level" value="{{ old('potassium_level') }}" data-profile-potassium>
                    </label>
                    <label class="dash-field">
                        <span>pH Value</span>
                        <input class="dash-input" type="number" step="0.01" min="0" max="14" name="ph_value" value="{{ old('ph_value') }}" data-profile-ph>
                    </label>
                    <label class="dash-field"><span>Organic Carbon</span><input class="dash-input" type="number" step="0.01" min="0" name="organic_carbon" value="{{ old('organic_carbon') }}" data-profile-organic-carbon></label>
                    <label class="dash-field"><span>Soil Moisture</span><input class="dash-input" type="number" step="0.01" min="0" max="100" name="soil_moisture" value="{{ old('soil_moisture') }}" data-profile-moisture></label>
                    <label class="dash-field dash-field--full">
                        <span>Current Problem / Symptom</span>
                        <textarea class="dash-textarea" name="current_problem">{{ old('current_problem') }}</textarea>
                    </label>
                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">Recommend Fertilizer</button>
                    </div>
                </form>
            </article>

            <article class="dash-card dash-card--soft-amber">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Recommendation Result</p>
                        <h2>Fertilizer plan</h2>
                    </div>
                </div>

                @if ($result)
                    <div class="dash-fertilizer-hero">
                        <div class="dash-fertilizer-bag"></div>
                        <div>
                            <p class="dash-label">Recommended Fertilizer</p>
                            <h3>{{ $result->recommended_fertilizer }}</h3>
                            <p>{{ $result->reason }}</p>
                        </div>
                        <span class="dash-badge dash-badge--orange">{{ $result->growth_stage }}</span>
                    </div>
                    <div class="dash-detail-list">
                        <div><span>Dosage</span><strong>{{ $result->dosage_advice }}</strong></div>
                        <div><span>Timing</span><strong>{{ $result->application_timing }}</strong></div>
                        <div><span>Caution</span><strong>{{ $result->caution }}</strong></div>
                        <div><span>Soil Snapshot</span><strong>{{ data_get($result->soil_snapshot, 'soil_type', $result->soil_type) }}</strong></div>
                    </div>
                    <p class="dash-note">Fertilizer recommendations are general guidance. Actual application should follow a recent soil test and local agricultural expert advice.</p>
                @else
                    <p class="dash-note">Submit the form to save a fertilizer recommendation.</p>
                @endif
            </article>
        </section>

        @include('dashboard_ui.partials.recent-records', ['records' => $records, 'columns' => ['crop_name' => 'Crop', 'location_name' => 'Location', 'recommended_fertilizer' => 'Fertilizer', 'growth_stage' => 'Stage']])
    </div>
@endsection

@push('scripts')
    @include('dashboard_ui.partials.feature-scripts')
    <script src="{{ asset('js/soil-profile-fill.js') }}" defer></script>
@endpush
