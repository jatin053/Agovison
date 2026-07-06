@extends('dashboard_ui.layout')

@php($editing = filled($profile))

@section('title', $editing ? 'Update Soil Scan' : 'Scan Soil Type')
@section('subtitle', 'Upload a clear soil photo and tell us which crop is currently planted in the field.')

@section('content')
    <div class="dash-content-stack">
        @include('dashboard_ui.partials.form-errors')

        <section class="dash-grid dash-grid--2-1">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">AI Soil Scan</p>
                        <h2>{{ $editing ? 'Update soil photo or crop' : 'Identify soil from a photo' }}</h2>
                    </div>
                </div>

                <form class="dash-field-grid" method="POST"
                      action="{{ $editing ? route('dashboard.soil.update', $profile) : route('dashboard.soil.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if ($editing)
                        @method('PUT')
                    @endif

                    <label class="dash-field dash-field--full">
                        <span>Crop currently planted in your field</span>
                        <input class="dash-input" name="crop_name" list="soilCropOptions"
                               value="{{ old('crop_name', $profile?->crop_name) }}"
                               placeholder="Example: Wheat, Rice, Maize, Tomato" required>
                        <datalist id="soilCropOptions">
                            @foreach ($crops as $crop)
                                <option value="{{ $crop }}"></option>
                            @endforeach
                        </datalist>
                    </label>

                    <label class="dash-field dash-field--full">
                        <span>{{ $editing ? 'New soil photo (optional)' : 'Soil photo' }}</span>
                        <div class="dash-upload">
                            <img id="soilImagePreview"
                                 src="{{ $editing && $profile?->soil_image_path ? asset('storage/'.$profile->soil_image_path) : '' }}"
                                 alt="Soil image preview"
                                 style="{{ $editing && $profile?->soil_image_path ? '' : 'display:none;' }}width:100%;max-width:420px;height:260px;object-fit:cover;border-radius:18px;">
                            <input id="soilImageInput" type="file" name="soil_image"
                                   accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   @required(! $editing)>
                            <p class="dash-note">Use a close, clear daylight photo of exposed soil. Remove leaves, plants, tools, and strong shadows. Maximum 5 MB.</p>
                        </div>
                    </label>

                    <div class="dash-field dash-field--full">
                        <button class="dash-button dash-button--primary dash-button--full" type="submit">
                            {{ $editing ? 'Update Soil Scan' : 'Detect Soil Type' }}
                        </button>
                    </div>
                </form>
            </article>

            <aside class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Photo Guide</p><h2>Get a better scan</h2></div>
                </div>
                <ul class="dash-check-list">
                    <li>Photograph bare soil from close range.</li>
                    <li>Use natural daylight without flash.</li>
                    <li>Keep the camera focused and steady.</li>
                    <li>Enter the crop that is actually growing there.</li>
                </ul>
                <div class="dash-highlight">
                    <strong>Important limitation</strong>
                    <p>A photo can estimate visible soil type, but it cannot measure pH, nitrogen, phosphorus, potassium, or contamination. Use a laboratory soil test for fertilizer decisions.</p>
                </div>
            </aside>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('soilImageInput')?.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            const preview = document.getElementById('soilImagePreview');
            if (!file || !preview) return;
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        });
    </script>
@endpush
