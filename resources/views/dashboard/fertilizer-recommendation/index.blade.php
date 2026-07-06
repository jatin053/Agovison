@extends('dashboard_ui.layout')

@section('title', 'Fertilizer Recommendation')
@section('subtitle', 'Combine live weather, detected soil type, crop stage, and measured nutrients for safer guidance.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.fertilizer.history') }}">History</a>
@endsection

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Field Inputs</p>
                        <h2>Build a fertilizer plan</h2>
                    </div>
                </div>

                <form class="dash-field-grid" method="POST" action="{{ route('dashboard.fertilizer.store') }}">
                    @csrf

                    <div class="dash-field dash-field--full dash-form-divider">
                        <strong>1. Crop and soil</strong>
                        <p class="dash-note">A saved photo scan can fill soil type, but cannot measure nutrients or pH.</p>
                    </div>

                    <label class="dash-field dash-field--full">
                        <span>Saved Soil Scan (Optional)</span>
                        <select class="dash-select" name="soil_profile_id" data-soil-profile-select>
                            <option value="">Choose a scan, or select soil type manually</option>
                            @foreach ($soilProfiles as $profile)
                                <option value="{{ $profile->id }}"
                                        data-soil-type="{{ $profile->soil_type }}"
                                        data-ph="{{ $profile->ph_value }}"
                                        data-nitrogen="{{ $profile->nitrogen_value }}"
                                        data-phosphorus="{{ $profile->phosphorus_value }}"
                                        data-potassium="{{ $profile->potassium_value }}"
                                        @selected((string) old('soil_profile_id') === (string) $profile->id)>
                                    {{ $profile->soil_type }} | {{ $profile->crop_name ?: 'Crop not recorded' }} | {{ number_format((float) $profile->confidence, 0) }}%
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="dash-field">
                        <span>Crop</span>
                        <select class="dash-select" name="crop_name" required>
                            @foreach ($crops as $crop)
                                <option @selected(old('crop_name') === $crop)>{{ $crop }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Detected / Selected Soil</span>
                        <select class="dash-select" name="soil_type" data-profile-soil-type>
                            @foreach ($soils as $soil)
                                <option @selected(old('soil_type') === $soil)>{{ $soil }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Season</span>
                        <select class="dash-select" name="season">
                            @foreach ($seasons as $season)
                                <option @selected(old('season') === $season)>{{ $season }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Growth Stage</span>
                        <select class="dash-select" name="growth_stage">
                            @foreach ($stages as $stage)
                                <option @selected(old('growth_stage') === $stage)>{{ $stage }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="dash-field dash-field--full dash-form-divider">
                        <strong>2. Location and live weather</strong>
                        <p class="dash-note">OpenWeather supplies temperature, humidity, rainfall, and conditions for application timing.</p>
                    </div>
                    @include('dashboard_ui.partials.location-weather-fields')

                    <div class="dash-field dash-field--full dash-form-divider">
                        <strong>3. Soil-test nutrients</strong>
                        <p class="dash-note">Choose Low / Medium / High from your soil report, or enter exact values below. These are never guessed from weather or a photo.</p>
                    </div>

                    @foreach (['nitrogen' => 'Nitrogen', 'phosphorus' => 'Phosphorus', 'potassium' => 'Potassium'] as $key => $label)
                        <label class="dash-field">
                            <span>{{ $label }} Level</span>
                            <select class="dash-select" name="{{ $key }}_level">
                                <option value="">Select from soil report</option>
                                @foreach ($levels as $level)
                                    <option @selected(old($key.'_level') === $level)>{{ $level }}</option>
                                @endforeach
                            </select>
                        </label>
                    @endforeach
                    <label class="dash-field">
                        <span>Soil pH (Optional)</span>
                        <input class="dash-input" type="number" step="0.01" min="0" max="14"
                               name="ph_value" value="{{ old('ph_value') }}" data-profile-ph>
                    </label>

                    <details class="dash-field dash-field--full fertilizer-exact-values">
                        <summary>Enter exact NPK values instead</summary>
                        <div class="dash-field-grid">
                            @foreach (['nitrogen' => 'Nitrogen', 'phosphorus' => 'Phosphorus', 'potassium' => 'Potassium'] as $key => $label)
                                <label class="dash-field">
                                    <span>{{ $label }} Value</span>
                                    <input class="dash-input" type="number" step="0.01" min="0"
                                           name="{{ $key }}_value" value="{{ old($key.'_value') }}"
                                           data-profile-{{ $key }}>
                                </label>
                            @endforeach
                        </div>
                    </details>

                    <div class="dash-field dash-field--full dash-form-divider">
                        <strong>4. Field context</strong>
                        <p class="dash-note">If NPK is unavailable, select a visible problem so the system can return cautious guidance.</p>
                    </div>

                    <label class="dash-field">
                        <span>Current Problem</span>
                        <select class="dash-select" name="current_problem">
                            <option value="">Select problem</option>
                            @foreach ($problems as $problem)
                                <option @selected(old('current_problem') === $problem)>{{ $problem }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Irrigation</span>
                        <select class="dash-select" name="irrigation_type">
                            <option value="">Select irrigation</option>
                            @foreach ($irrigationTypes as $type)
                                <option @selected(old('irrigation_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Previous Fertilizer</span>
                        <input class="dash-input" name="previous_fertilizer" value="{{ old('previous_fertilizer') }}" placeholder="Optional">
                    </label>
                    <label class="dash-field">
                        <span>Last Application</span>
                        <input class="dash-input" type="date" name="last_application_date" value="{{ old('last_application_date') }}">
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Preference</span>
                        <select class="dash-select" name="organic_preference">
                            @foreach ($organicPreferences as $preference)
                                <option @selected(old('organic_preference') === $preference)>{{ $preference }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">
                            Generate Fertilizer Guidance
                        </button>
                    </div>
                </form>
            </article>

            <aside class="dash-card dash-card--soft-green fertilizer-info-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">How It Works</p><h2>Every value has a clear source</h2></div>
                </div>
                <div class="dash-detail-list">
                    <div><span>Location & weather</span><strong>OpenWeather API</strong></div>
                    <div><span>Soil type</span><strong>Saved AI photo scan or manual selection</strong></div>
                    <div><span>pH and NPK</span><strong>Your soil-test report</strong></div>
                    <div><span>Recommendation</span><strong>Database-backed fertilizer rule API</strong></div>
                </div>
                <div class="dash-highlight">
                    <strong>Why NPK is not auto-filled</strong>
                    <p>A camera and weather service cannot measure soil chemistry. Guessing these values could produce unsafe fertilizer advice.</p>
                </div>
                <div class="dash-highlight dash-highlight--soft">
                    <strong>Safety</strong>
                    <p>The result provides fertilizer type and timing guidance—not an unrestricted dosage prescription. Always follow the product label and local expert advice.</p>
                </div>
            </aside>
        </section>

        @include('dashboard_ui.partials.recent-records', [
            'records' => $records,
            'columns' => ['crop_name' => 'Crop', 'location_name' => 'Location', 'recommended_fertilizer_name' => 'Fertilizer', 'confidence' => 'Confidence']
        ])
    </div>
@endsection

@push('scripts')
    @include('dashboard_ui.partials.feature-scripts')
    <script src="{{ asset('js/soil-profile-fill.js') }}" defer></script>
@endpush
