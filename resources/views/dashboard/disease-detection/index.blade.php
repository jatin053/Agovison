@extends('dashboard_ui.layout')

@section('title', 'Disease Detection')
@section('subtitle', 'Upload a crop image, note the symptoms, and send the report to the Python disease API.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.disease.history') }}">View History</a>
@endsection

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2-1">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Disease Form</p>
                        <h2>Detect crop disease</h2>
                    </div>
                </div>

                <form class="dash-field-grid disease-form" method="POST" action="{{ route('dashboard.disease.store') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="dash-field">
                        <span>Crop Name</span>
                        <select class="dash-select" name="crop_name" required>
                            <option value="">Select crop</option>
                            @foreach ($supportedCrops as $crop)
                                <option @selected(old('crop_name') === $crop)>{{ $crop }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="dash-field">
                        <span>Affected Plant Part</span>
                        <select class="dash-select" name="affected_part" required>
                            <option value="">Select part</option>
                            @foreach ($affectedParts as $part)
                                <option @selected(old('affected_part') === $part)>{{ $part }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="dash-field">
                        <span>Symptoms</span>
                        <select class="dash-select" name="symptoms" required>
                            <option value="">Select symptom</option>
                            @foreach ($symptomOptions as $symptom)
                                <option @selected(old('symptoms') === $symptom)>{{ $symptom }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="dash-field">
                        <span>Location</span>
                        <input class="dash-input" type="text" name="location" value="{{ old('location') }}" placeholder="Village, city, or farm name" data-google-location required>
                    </label>

                    <div class="dash-field">
                        <span>Current Location</span>
                        <button class="dash-button dash-button--ghost" type="button"
                                data-use-live-location
                                data-location-target="location"
                                data-reverse-location="{{ route('dashboard.location.reverse') }}">
                            Use My Current Location
                        </button>
                        <p class="dash-note" data-location-status>You can also enter the field location manually.</p>
                    </div>

                    <label class="dash-field">
                        <span>Crop Age</span>
                        <input class="dash-input" type="text" name="crop_age" value="{{ old('crop_age') }}" placeholder="Example: 45 days" required>
                    </label>

                    <label class="dash-field">
                        <span>When Symptoms Started</span>
                        <input class="dash-input" type="date" name="symptom_started" value="{{ old('symptom_started') }}" required>
                    </label>

                    <label class="dash-field">
                        <span>Percentage of Field Affected</span>
                        <input class="dash-input" type="number" step="0.01" min="0" max="100" name="field_affected" value="{{ old('field_affected') }}" required>
                    </label>

                    <label class="dash-field">
                        <span>Recent Fertilizer Use</span>
                        <textarea class="dash-textarea" name="fertilizer_used" placeholder="Recent fertilizer application details">{{ old('fertilizer_used') }}</textarea>
                    </label>

                    <label class="dash-field">
                        <span>Recent Pesticide Use</span>
                        <textarea class="dash-textarea" name="pesticide_used" placeholder="Recent pesticide application details">{{ old('pesticide_used') }}</textarea>
                    </label>

                    <label class="dash-field dash-field--full">
                        <span>Leaf or Plant Image</span>
                        <div class="dash-upload">
                            <img id="diseaseImagePreview" src="" alt="Image preview" style="display:none;width:100%;max-width:320px;height:220px;object-fit:cover;border-radius:18px;">
                            <span class="dash-upload__icon" aria-hidden="true">
                                @include('dashboard_ui.partials.icon', ['icon' => 'upload'])
                            </span>
                            <input id="leafImageInput" type="file" name="leaf_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
                            <p class="dash-note">Accepted formats: JPG, JPEG, PNG, WEBP. Max size: 5 MB.</p>
                        </div>
                    </label>

                    <div class="dash-card__footer dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">Detect Crop Disease</button>
                    </div>
                </form>
            </article>

            <aside class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Guide</p>
                        <h2>How to submit a good scan</h2>
                    </div>
                </div>

                <div class="dash-list">
                    <div class="dash-list__item">
                        <div>
                            <strong>Upload a clear leaf image</strong>
                            <p>Use a bright, focused image with the diseased area visible.</p>
                        </div>
                    </div>
                    <div class="dash-list__item">
                        <div>
                            <strong>Pick the correct crop</strong>
                            <p>Tomato, Potato, Rice, Wheat, or Maize.</p>
                        </div>
                    </div>
                    <div class="dash-list__item">
                        <div>
                            <strong>Describe the symptoms</strong>
                            <p>Use the visible symptom selector and add extra notes if needed.</p>
                        </div>
                    </div>
                    <div class="dash-list__item">
                        <div>
                            <strong>Check the disclaimer</strong>
                            <p>This is a preliminary assessment and should not replace an expert diagnosis.</p>
                        </div>
                    </div>
                </div>

                <section class="dash-card dash-card--nested">
                    <div class="dash-card__header">
                        <div>
                            <p class="dash-eyebrow">Supported Crops</p>
                            <h2>Current crop list</h2>
                        </div>
                    </div>
                    <div class="dash-chip-row">
                        @foreach ($supportedCrops as $crop)
                            <span class="dash-chip dash-chip--green">{{ $crop }}</span>
                        @endforeach
                    </div>
                </section>

                <div class="dash-highlight">
                    <strong>Important Diagnosis Disclaimer</strong>
                    <p>This result is an AI-based preliminary assessment and should not replace professional agricultural or laboratory diagnosis.</p>
                </div>
            </aside>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Recent Activity</p>
                    <h2>Your latest disease scans</h2>
                </div>
                <span class="dash-badge dash-badge--green">{{ $totalChecks }} total checks</span>
            </div>

            @if ($latestReport)
                <div class="dash-detail-list">
                    <div><span>Latest Disease Result</span><strong>{{ $latestReport->disease_name }} - {{ number_format((float) $latestReport->confidence, 2) }}%</strong></div>
                    <div><span>Latest Location</span><strong>{{ $latestReport->location }}</strong></div>
                </div>
            @endif

            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Crop</th>
                            <th>Disease</th>
                            <th>Confidence</th>
                            <th>Severity</th>
                            <th>Location</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentReports as $record)
                            <tr>
                                <td>{{ $record->crop_name }}</td>
                                <td>{{ $record->disease_name }}</td>
                                <td>{{ number_format((float) $record->confidence, 2) }}%</td>
                                <td>{{ $record->severity }}</td>
                                <td>{{ $record->location }}</td>
                                <td>{{ $record->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No disease scans saved yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/google-location.js') }}" defer></script>
    <script src="{{ asset('js/disease-detection.js') }}" defer></script>
@endpush
