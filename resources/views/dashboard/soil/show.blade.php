@extends('dashboard_ui.layout')

@section('title', 'Soil Scan Result')
@section('subtitle', 'Review the visually estimated soil type and crop guidance.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.soil.edit', $profile) }}">Update Scan</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.soil.history') }}">History</a>
@endsection

@section('content')
    <section class="dash-card dash-card--soft-green">
        <div class="dash-card__header">
            <div><p class="dash-eyebrow">AI Soil Report</p><h2>{{ $profile->soil_type }}</h2></div>
            <span class="dash-badge dash-badge--green">{{ number_format((float) $profile->confidence, 2) }}%</span>
        </div>

        <div class="dash-result-hero">
            <div class="dash-result-hero__media">
                @if ($profile->soil_image_path)
                    <img src="{{ asset('storage/'.$profile->soil_image_path) }}" alt="Uploaded soil sample"
                         style="width:100%;height:100%;object-fit:cover;border-radius:24px;">
                @endif
            </div>
            <div class="dash-result-hero__copy">
                <p class="dash-label">Detected soil type</p>
                <h3>{{ $profile->soil_type }}</h3>
                <p class="dash-note">Current crop: <strong>{{ $profile->crop_name }}</strong></p>
            </div>
        </div>

        <div class="dash-highlight">
            <strong>Crop guidance</strong>
            <p>{{ $profile->crop_advice }}</p>
        </div>

        <div class="dash-highlight dash-highlight--soft">
            <strong>Photo-based estimate</strong>
            <p>This result describes visible soil appearance only. Confirm soil chemistry and fertilizer requirements with a laboratory test or local agriculture expert.</p>
        </div>

        <div class="dash-button-row">
            <form method="POST" action="{{ route('dashboard.soil.destroy', $profile) }}">
                @csrf
                @method('DELETE')
                <button class="dash-button dash-button--link" type="submit">Delete Scan</button>
            </form>
        </div>
    </section>
@endsection
