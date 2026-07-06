@extends('dashboard_ui.layout')

@section('title', 'Disease Detection')
@section('subtitle', 'Upload a leaf image for placeholder detection now, with a clean endpoint ready for a Python ML API later.')

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Image Upload</p>
                        <h2>Check leaf symptoms</h2>
                    </div>
                </div>

                <form class="dash-field-grid" method="POST" action="{{ route('dashboard.disease.store') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="dash-field">
                        <span>Crop Name</span>
                        <input class="dash-input" name="crop_name" value="{{ old('crop_name') }}" required>
                    </label>
                    <label class="dash-field">
                        <span>Plant Part</span>
                        <select class="dash-select" name="plant_part">
                            @foreach (['Leaf', 'Stem', 'Fruit', 'Root', 'Whole Plant'] as $part)
                                <option @selected(old('plant_part') === $part)>{{ $part }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Visible Symptom</span>
                        <select class="dash-select" name="visible_symptom" required>
                            <option value="">Select the main visible issue</option>
                            @foreach (['Yellow leaves / curling', 'Brown or black spots', 'White powder on leaves', 'Wilting or drying', 'Holes / pest damage', 'Rotten area', 'Other visible issue'] as $symptom)
                                <option @selected(old('visible_symptom') === $symptom)>{{ $symptom }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Symptom Notes Optional</span>
                        <textarea class="dash-textarea" name="symptom_notes" placeholder="Example: brown circular spots on lower leaves, spreading after rain">{{ old('symptom_notes') }}</textarea>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Leaf Image</span>
                        <div class="dash-upload">
                            <span class="dash-upload__icon" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => 'upload'])
                            </span>
                            <input type="file" name="leaf_image" accept="image/*" required>
                            <p class="dash-note">JPG, PNG, or WEBP up to 5 MB.</p>
                        </div>
                    </label>
                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">Detect Disease</button>
                    </div>
                </form>
            </article>

            <article class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Detection Result</p>
                        <h2>Leaf analysis</h2>
                    </div>
                    @if ($result)
                        <span class="dash-badge dash-badge--green">{{ $result->confidence_score }}%</span>
                    @endif
                </div>

                @if ($result)
                    <div class="dash-result-hero">
                        <div class="dash-result-hero__media dash-result-hero__media--leaf"></div>
                        <div class="dash-result-hero__copy">
                            <p class="dash-label">Detected Disease</p>
                            <h3>{{ $result->detected_disease }}</h3>
                            <span class="dash-badge dash-badge--orange">{{ $result->severity }}</span>
                            <p>{{ $result->treatment_suggestion }}</p>
                        </div>
                        <div class="dash-score-card">
                            <div class="dash-score-ring" style="--progress: {{ $result->confidence_score }}">
                                <strong>{{ $result->confidence_score }}%</strong>
                            </div>
                        </div>
                    </div>
                    <div class="dash-detail-list">
                        <div><span>Visible Symptom</span><strong>{{ $result->visible_symptom ?? 'N/A' }}</strong></div>
                        <div><span>Analysis Source</span><strong>{{ $result->analysis_source === 'python_ml_api' ? 'Python ML API' : 'Local preliminary rules' }}</strong></div>
                        <div><span>Important</span><strong>{{ $result->analysis_source === 'python_ml_api' ? 'Model result saved from API.' : 'Preliminary result. Add DISEASE_API_URL for real image ML detection.' }}</strong></div>
                    </div>
                @else
                    <p class="dash-note">Upload an image and select the visible symptom to save a disease detection record.</p>
                @endif
            </article>
        </section>

        @include('dashboard_ui.partials.recent-records', ['records' => $records, 'columns' => ['crop_name' => 'Crop', 'visible_symptom' => 'Symptom', 'detected_disease' => 'Disease', 'confidence_score' => 'Confidence']])
    </div>
@endsection
