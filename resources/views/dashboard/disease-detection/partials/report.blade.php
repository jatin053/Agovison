@php
    $alternatives = collect($record->alternatives ?? []);
    $productRecommendations = collect($record->productRecommendations());
    $imageUrl = $record->image_path
        ? asset('storage/'.$record->image_path)
        : ($record->leaf_image_path ? asset('storage/'.$record->leaf_image_path) : null);
@endphp

<section class="dash-card dash-card--soft-green">
    <div class="dash-card__header">
        <div>
            <p class="dash-eyebrow">Disease Report</p>
            <h2>{{ $record->crop_name }} assessment</h2>
        </div>
        <span class="dash-badge {{ $record->confidence >= 85 ? 'dash-badge--green' : ($record->confidence >= 60 ? 'dash-badge--orange' : 'dash-badge--blue') }}">
            {{ number_format((float) $record->confidence, 2) }}%
        </span>
    </div>

    <div class="dash-result-hero">
        <div class="dash-result-hero__media dash-result-hero__media--leaf">
            @if ($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $record->crop_name }} disease upload" style="width:100%;height:100%;object-fit:cover;border-radius:24px;">
            @endif
        </div>
        <div class="dash-result-hero__copy">
            <p class="dash-label">Most Likely Disease</p>
            <h3>{{ $record->disease_name }}</h3>
            <span class="dash-badge dash-badge--green">{{ $record->severity }}</span>
            <p class="dash-note">{{ $record->status }}</p>
        </div>
        <div class="dash-score-card">
            <div class="dash-score-ring" style="--progress: {{ (float) $record->confidence }}">
                <strong>{{ number_format((float) $record->confidence, 0) }}%</strong>
            </div>
            <p>{{ $record->confidence >= 85 ? 'High-confidence result' : ($record->confidence >= 60 ? 'Possible disease' : 'Low confidence') }}</p>
        </div>
    </div>

    <section class="disease-action-box" aria-labelledby="disease-action-title">
        <div class="disease-action-box__header">
            <p class="dash-eyebrow">Diagnosis & Action</p>
            <h2 id="disease-action-title">Issue and recommended solution</h2>
        </div>

        <div class="disease-action-box__grid">
            <article class="disease-action-box__section disease-action-box__section--issue">
                <span class="disease-action-box__number">01</span>
                <div>
                    <p class="dash-label">Detected issue</p>
                    <h3>{{ $record->disease_name }}</h3>
                    <strong>Why this may be happening</strong>
                    <p>{{ $record->possible_cause }}</p>
                </div>
            </article>

            <article class="disease-action-box__section disease-action-box__section--solution">
                <span class="disease-action-box__number">02</span>
                <div>
                    <p class="dash-label">Recommended solution</p>
                    <h3>What you should do next</h3>
                    <strong>Treatment</strong>
                    <p>{{ $record->treatment }}</p>
                    <strong>Prevention</strong>
                    <p>{{ $record->prevention }}</p>
                </div>
            </article>
        </div>
    </section>

    <div class="dash-detail-list">
        <div><span>Crop</span><strong>{{ $record->crop_name }}</strong></div>
        <div><span>Affected Part</span><strong>{{ $record->affected_part }}</strong></div>
        <div><span>Symptoms</span><strong>{{ $record->symptoms }}</strong></div>
        <div><span>Location</span><strong>{{ $record->location }}</strong></div>
        <div><span>Date</span><strong>{{ $record->created_at?->format('M d, Y') }}</strong></div>
        <div><span>Crop Age</span><strong>{{ $record->crop_age }}</strong></div>
        <div><span>Symptoms Started</span><strong>{{ \Illuminate\Support\Carbon::parse($record->symptom_started)->format('M d, Y') }}</strong></div>
        <div><span>Field Affected</span><strong>{{ $record->field_affected }}%</strong></div>
        <div><span>Recent Fertilizer</span><strong>{{ $record->fertilizer_used ?: 'None provided' }}</strong></div>
        <div><span>Recent Pesticide</span><strong>{{ $record->pesticide_used ?: 'None provided' }}</strong></div>
    </div>

    <section class="dash-card dash-card--nested">
        <div class="dash-card__header">
            <div>
                <p class="dash-eyebrow">Suggested Products</p>
                <h2>Products to ask for at an agriculture store</h2>
            </div>
        </div>

        <div class="dash-list">
            @foreach ($productRecommendations as $product)
                <div class="dash-list__item">
                    <div>
                        <strong>{{ $product['name'] }}</strong>
                        <p>{{ $product['type'] }} - {{ $product['reason'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dash-highlight">
            <strong>Before buying</strong>
            <p>Show this report to a local agriculture shop or expert and buy only products approved for your crop, disease, and location. Always follow the product label dosage and safety instructions.</p>
        </div>
    </section>

    <div class="dash-highlight">
        <strong>Disclaimer</strong>
        <p>This result is an AI-based preliminary assessment and should not replace professional agricultural or laboratory diagnosis.</p>
    </div>

    @if ($alternatives->isNotEmpty())
        <section class="dash-card dash-card--nested">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Alternatives</p>
                    <h2>Top other possibilities</h2>
                </div>
            </div>

            <div class="dash-list">
                @foreach ($alternatives as $alternative)
                    <div class="dash-list__item">
                        <div>
                            <strong>{{ $alternative['disease'] ?? $alternative['name'] ?? 'Alternative disease' }}</strong>
                            <p>{{ isset($alternative['confidence']) ? number_format((float) $alternative['confidence'], 2) . '%' : 'Confidence unavailable' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</section>
