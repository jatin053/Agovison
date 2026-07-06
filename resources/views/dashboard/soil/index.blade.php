@extends('dashboard_ui.layout')

@section('title', 'Soil Information')
@section('subtitle', 'Upload a soil photo, identify its visible type, and review guidance for your current crop.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.soil.history') }}">Soil History</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.soil.create') }}">Scan Soil</a>
@endsection

@section('content')
    <div class="dash-content-stack">
        <section class="dash-card dash-card--soft-green">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Soil Module</p>
                    <h2>Identify visible soil type from a field photo.</h2>
                    <p class="dash-note">Upload exposed soil in clear daylight and enter the crop currently planted in the field.</p>
                </div>
            </div>
            <div class="dash-button-row">
                <a class="dash-button dash-button--primary" href="{{ route('dashboard.soil.create') }}">Upload Soil Photo</a>
            </div>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div><p class="dash-eyebrow">Recent Soil Profiles</p><h2>{{ $profiles->count() }} saved profiles</h2></div>
            </div>
            <div class="dash-list">
                @forelse ($profiles as $profile)
                    <div class="dash-list__item">
                        <div>
                            <strong>{{ $profile->soil_type }}</strong>
                            <p>{{ $profile->crop_name ?: 'Crop not recorded' }} | {{ number_format((float) $profile->confidence, 2) }}% | {{ $profile->created_at?->format('M d, Y') }}</p>
                        </div>
                        <a class="dash-button dash-button--ghost" href="{{ route('dashboard.soil.show', $profile) }}">View</a>
                    </div>
                @empty
                    <p class="dash-note">No soil profiles saved yet.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
