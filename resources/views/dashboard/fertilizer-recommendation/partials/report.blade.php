@php
    $reasons = collect(is_array($record->reason) ? $record->reason : [$record->reason])->filter();
    $warnings = collect($record->warnings ?? [])->filter();
    $alternatives = collect($record->alternatives ?? []);
@endphp

<section class="dash-card dash-card--soft-green">
    <div class="dash-card__header">
        <div><p class="dash-eyebrow">Fertilizer Report</p><h2>{{ $record->recommended_fertilizer_name ?: $record->recommended_fertilizer }}</h2></div>
        <span class="dash-badge {{ $record->confidence >= 85 ? 'dash-badge--green' : ($record->confidence >= 60 ? 'dash-badge--orange' : 'dash-badge--blue') }}">{{ number_format((float) $record->confidence, 2) }}%</span>
    </div>

    <div class="dash-detail-list">
        <div><span>Crop</span><strong>{{ $record->crop_name }}</strong></div>
        <div><span>Soil Type</span><strong>{{ $record->soil_type }}</strong></div>
        <div><span>pH</span><strong>{{ $record->ph_value ?: 'N/A' }}</strong></div>
        <div><span>NPK</span><strong>{{ $record->nitrogen_level ?: $record->nitrogen_value ?: 'N/A' }} / {{ $record->phosphorus_level ?: $record->phosphorus_value ?: 'N/A' }} / {{ $record->potassium_level ?: $record->potassium_value ?: 'N/A' }}</strong></div>
        <div><span>Problem</span><strong>{{ $record->current_problem ?: 'N/A' }}</strong></div>
        <div><span>Weather</span><strong>{{ $record->temperature ?: 'N/A' }} C, {{ $record->humidity ?: 'N/A' }}% humidity, {{ $record->rainfall ?: 'N/A' }} rainfall</strong></div>
        <div><span>Status</span><strong>{{ $record->status }}</strong></div>
        <div><span>Date</span><strong>{{ $record->created_at?->format('M d, Y') }}</strong></div>
    </div>

    <div class="dash-highlight">
        <strong>Application timing</strong>
        <p>{{ $record->application_timing }}</p>
    </div>

    <section class="dash-card dash-card--nested">
        <div class="dash-card__header"><div><p class="dash-eyebrow">Reasons</p><h2>Why this fertilizer was selected</h2></div></div>
        <ul class="dash-check-list">@foreach ($reasons as $reason)<li>{{ $reason }}</li>@endforeach</ul>
    </section>

    @if ($warnings->isNotEmpty())
        <section class="dash-card dash-card--nested">
            <div class="dash-card__header"><div><p class="dash-eyebrow">Warnings</p><h2>Use safely</h2></div></div>
            <ul class="dash-check-list">@foreach ($warnings as $warning)<li>{{ $warning }}</li>@endforeach</ul>
        </section>
    @endif

    @if ($alternatives->isNotEmpty())
        <section class="dash-card dash-card--nested">
            <div class="dash-card__header"><div><p class="dash-eyebrow">Alternatives</p><h2>Other possible options</h2></div></div>
            <div class="dash-list">@foreach ($alternatives as $alternative)<div class="dash-list__item"><div><strong>{{ $alternative['name'] ?? 'Alternative' }}</strong><p>{{ $alternative['confidence'] ?? 'N/A' }}% | {{ $alternative['reason'] ?? 'Alternative nutrient support' }}</p></div></div>@endforeach</div>
        </section>
    @endif

    <div class="dash-highlight">
        <strong>Disclaimer</strong>
        <p>This recommendation is general guidance based on the provided soil, crop and weather information. Actual fertilizer selection and application should follow a current soil test, product label and local agricultural expert advice.</p>
    </div>
</section>
