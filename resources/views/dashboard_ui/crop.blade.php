@extends('dashboard_ui.layout')

@section('title', 'Crop Recommendation')
@section('subtitle', 'Get the best crop suggestions based on your field, soil profile, and seasonal conditions.')

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Input Details</p>
                        <h2>Enter field and soil data</h2>
                    </div>
                </div>

                <form class="dash-field-grid" method="POST" action="{{ route('dashboard.crop.store') }}">
                    @csrf
                    <label class="dash-field">
                        <span>Crop Name (Optional)</span>
                        <input class="dash-input" type="text" name="crop_name" value="{{ old('crop_name') }}" placeholder="Leave blank for best match">
                    </label>
                    <label class="dash-field">
                        <span>Soil Type</span>
                        <select class="dash-select" name="soil_type" required>
                            @foreach (['Loamy', 'Clay', 'Sandy', 'Black Soil', 'Alluvial'] as $soil)
                                <option @selected(old('soil_type') === $soil)>{{ $soil }}</option>
                            @endforeach
                        </select>
                    </label>
                    @include('dashboard_ui.partials.location-weather-fields')
                    <div class="dash-field dash-field--full dash-form-divider">
                        <strong>Soil test values</strong>
                        <p class="dash-note">Enter pH and NPK from a soil test report; weather fetching cannot measure these values.</p>
                    </div>
                    <label class="dash-field">
                        <span>pH Value</span>
                        <input class="dash-input" type="number" step="0.01" min="0" max="14" name="ph_value" value="{{ old('ph_value') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Nitrogen (kg/ha)</span>
                        <input class="dash-input" type="number" step="0.01" min="0" name="nitrogen" value="{{ old('nitrogen') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Phosphorus (kg/ha)</span>
                        <input class="dash-input" type="number" step="0.01" min="0" name="phosphorus" value="{{ old('phosphorus') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Potassium (kg/ha)</span>
                        <input class="dash-input" type="number" step="0.01" min="0" name="potassium" value="{{ old('potassium') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Season</span>
                        <select class="dash-select" name="season" required>
                            @foreach (['Kharif', 'Rabi', 'Summer', 'Winter', 'Monsoon'] as $season)
                                <option @selected(old('season') === $season)>{{ $season }}</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">Get Recommendation</button>
                    </div>
                </form>
            </article>

            <article class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Recommendation Result</p>
                        <h2>Best fit for the current field profile</h2>
                    </div>
                    @if ($result)
                        <span class="dash-badge dash-badge--green">{{ $result->confidence_score }}% Confidence</span>
                    @endif
                </div>

                @if ($result)
                    <div class="dash-result-hero">
                        <div class="dash-result-hero__media dash-result-hero__media--crop"></div>
                        <div class="dash-result-hero__copy">
                            <p class="dash-label">Recommended Crop</p>
                            <h3>{{ $result->recommended_crop }}</h3>
                            <p>{{ $result->reason }}</p>
                        </div>
                        <div class="dash-score-card">
                            <div class="dash-score-ring" style="--progress: {{ $result->confidence_score }}">
                                <strong>{{ $result->confidence_score }}%</strong>
                            </div>
                        </div>
                    </div>
                    <div class="dash-highlight">
                        <strong>Farming Advice</strong>
                        <p>{{ $result->farming_advice }}</p>
                    </div>
                @else
                    <p class="dash-note">Submit the form to generate and save your first crop recommendation.</p>
                @endif
            </article>
        </section>

        @include('dashboard_ui.partials.recent-records', ['records' => $records, 'columns' => ['crop_name' => 'Crop', 'location_name' => 'Location', 'recommended_crop' => 'Result', 'confidence_score' => 'Confidence']])
    </div>
@endsection

@push('scripts')
    @include('dashboard_ui.partials.feature-scripts')
@endpush
