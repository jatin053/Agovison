@forelse($crops as $crop)
    <div class="col-md-6 col-xl-4">
        <article class="crop-card marketplace-product-card h-100">
            <a href="{{ route('buyer.marketplace.show', $crop->slug) }}" class="marketplace-product-media">
                <img src="{{ $crop->primary_image_url }}" alt="{{ $crop->title }}">
                <div class="marketplace-product-badges">
                    <span class="badge-soft">{{ data_get($crop->meta, 'grade', 'Verified') }}</span>
                    @if($crop->organic)
                        <span class="badge-soft">Organic</span>
                    @endif
                </div>
            </a>

            <div class="marketplace-product-body">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <span class="badge-soft">{{ $crop->category->name }}</span>
                    <span class="marketplace-rating-chip">
                        <i class="fa-solid fa-star"></i>
                        {{ number_format($crop->reviews_avg_rating ?? 0, 1) }}
                        <small>({{ $crop->reviews_count }})</small>
                    </span>
                </div>

                <h5 class="mt-3 mb-2">{{ $crop->title }}</h5>
                <p class="marketplace-product-copy">{{ $crop->short_description ?: \Illuminate\Support\Str::limit($crop->description, 100) }}</p>

                <div class="marketplace-product-meta">
                    <span><i class="fa-solid fa-location-dot"></i> {{ $crop->location ?: 'Location on request' }}</span>
                    <span><i class="fa-solid fa-user"></i> {{ $crop->farmer->name }}</span>
                    <span><i class="fa-solid fa-box-open"></i> {{ $crop->stock }} {{ $crop->unit }}</span>
                    <span><i class="fa-solid fa-calendar-days"></i> {{ optional($crop->harvest_date)->format('d M') ?: 'Dispatch ready' }}</span>
                </div>

                <div class="marketplace-product-tags">
                    <span>{{ data_get($crop->meta, 'packaging', 'Packed lot') }}</span>
                    <span>{{ data_get($crop->meta, 'lead_time', 'Fast dispatch') }}</span>
                    <span>{{ data_get($crop->meta, 'min_order', 'Flexible MOQ') }}</span>
                </div>

                <div class="marketplace-product-footer">
                    <div class="marketplace-price-stack">
                        @if($crop->sale_price)
                            <small>INR {{ number_format((float) $crop->price, 2) }}</small>
                        @endif
                        <span class="crop-price">INR {{ number_format($crop->effective_price, 2) }}<em>/{{ $crop->unit }}</em></span>
                    </div>

                    <div class="d-flex gap-2">
                        @if(auth()->user()?->hasRole('Buyer'))
                            <form action="{{ route('buyer.cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="crop_id" value="{{ $crop->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn btn-outline-light btn-sm">Add</button>
                            </form>
                        @endif
                        <a href="{{ route('buyer.marketplace.show', $crop->slug) }}" class="btn btn-success btn-sm">Details</a>
                    </div>
                </div>
            </div>
        </article>
    </div>
@empty
    <div class="col-12">
        <div class="surface-card marketplace-empty-state text-center">
            <span class="hero-badge"><i class="fa-solid fa-magnifying-glass"></i> No direct matches</span>
            <h4 class="mt-3">No crops matched your current filters.</h4>
            <p class="muted-label">Try a broader keyword, remove one of the price limits, or start from one of the recommended listings below.</p>

            @if(($fallbackCrops ?? collect())->isNotEmpty())
                <div class="row g-4 mt-2 text-start">
                    @foreach($fallbackCrops as $crop)
                        <div class="col-md-6 col-xl-4">
                            <article class="marketplace-recommend-card h-100">
                                <img src="{{ $crop->primary_image_url }}" alt="{{ $crop->title }}">
                                <div class="marketplace-recommend-card__body">
                                    <span class="badge-soft">{{ $crop->category->name }}</span>
                                    <h5 class="mt-3 mb-2">{{ $crop->title }}</h5>
                                    <p class="muted-label">{{ \Illuminate\Support\Str::limit($crop->short_description ?: $crop->description, 90) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="crop-price">INR {{ number_format($crop->effective_price, 2) }}</div>
                                        <a href="{{ route('buyer.marketplace.show', $crop->slug) }}" class="btn btn-outline-light btn-sm">View</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endforelse
