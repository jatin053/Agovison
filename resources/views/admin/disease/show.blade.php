@extends('admin.layout')

@section('title', 'Disease Report')
@section('subtitle', 'Detailed report for a single disease scan.')

@section('header_actions')
    <a class="admin-button admin-button--ghost" href="{{ route('admin.disease.index') }}">Back to List</a>
    <form method="POST" action="{{ route('admin.disease.destroy', $record) }}" onsubmit="return confirm('Delete this disease report?')">
        @csrf
        @method('DELETE')
        <button class="admin-button admin-button--dark" type="submit">Delete Report</button>
    </form>
@endsection

@section('content')
    @php
        $imageUrl = $record->image_path
            ? asset('storage/'.$record->image_path)
            : ($record->leaf_image_path ? asset('storage/'.$record->leaf_image_path) : null);
    @endphp

    <div class="admin-grid admin-grid--2-1">
        <article class="admin-card">
            <div class="admin-card__header">
                <div>
                    <p class="admin-card__eyebrow">Uploaded Image</p>
                    <h2>{{ $record->crop_name }} scan</h2>
                </div>
            </div>

            @if ($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $record->crop_name }}" style="width:100%;max-height:420px;object-fit:cover;border-radius:24px;">
            @endif
        </article>

        <article class="admin-card">
            <div class="admin-card__header">
                <div>
                    <p class="admin-card__eyebrow">Summary</p>
                    <h2>{{ $record->disease_name }}</h2>
                </div>
            </div>

            <div class="admin-config-list">
                <div class="admin-config-list__item"><span>User</span><strong>{{ $record->user?->name ?? 'Deleted user' }}</strong></div>
                <div class="admin-config-list__item"><span>Email</span><strong>{{ $record->user?->email ?? 'N/A' }}</strong></div>
                <div class="admin-config-list__item"><span>Confidence</span><strong>{{ number_format((float) $record->confidence, 2) }}%</strong></div>
                <div class="admin-config-list__item"><span>Severity</span><strong>{{ $record->severity }}</strong></div>
                <div class="admin-config-list__item"><span>Location</span><strong>{{ $record->location }}</strong></div>
                <div class="admin-config-list__item"><span>Date</span><strong>{{ $record->created_at?->format('M d, Y') }}</strong></div>
            </div>
        </article>
    </div>

    <section class="admin-card">
        <div class="admin-card__header">
            <div>
                <p class="admin-card__eyebrow">Full Report</p>
                <h2>Diagnosis details</h2>
            </div>
        </div>

        <div class="admin-config-list">
            <div><span>Crop</span><strong>{{ $record->crop_name }}</strong></div>
            <div><span>Affected Part</span><strong>{{ $record->affected_part }}</strong></div>
            <div><span>Symptoms</span><strong>{{ $record->symptoms }}</strong></div>
            <div><span>Crop Age</span><strong>{{ $record->crop_age }}</strong></div>
            <div><span>Symptoms Started</span><strong>{{ \Illuminate\Support\Carbon::parse($record->symptom_started)->format('M d, Y') }}</strong></div>
            <div><span>Field Affected</span><strong>{{ $record->field_affected }}%</strong></div>
            <div><span>Recent Fertilizer</span><strong>{{ $record->fertilizer_used ?: 'None' }}</strong></div>
            <div><span>Recent Pesticide</span><strong>{{ $record->pesticide_used ?: 'None' }}</strong></div>
            <div><span>Possible Cause</span><strong>{{ $record->possible_cause }}</strong></div>
            <div><span>Treatment</span><strong>{{ $record->treatment }}</strong></div>
            <div><span>Prevention</span><strong>{{ $record->prevention }}</strong></div>
            <div><span>Status</span><strong>{{ $record->status }}</strong></div>
        </div>

        @if (! empty($record->alternatives))
            <div class="dash-highlight">
                <strong>Alternatives</strong>
                @foreach ($record->alternatives as $alternative)
                    <p>{{ $alternative['disease'] ?? 'Alternative' }} - {{ isset($alternative['confidence']) ? number_format((float) $alternative['confidence'], 2) . '%' : 'Confidence unavailable' }}</p>
                @endforeach
            </div>
        @endif

        <div class="dash-highlight">
            <strong>Disclaimer</strong>
            <p>This result is an AI-based preliminary assessment and should not replace professional agricultural or laboratory diagnosis.</p>
        </div>
    </section>
@endsection
