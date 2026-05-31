@extends('layouts.app')

@php($pageTitle = 'Marketplace')
@php($pageSubtitle = 'Source verified produce, compare harvest windows, and buy directly from trusted growers.')

@section('content')
    <div class="marketplace-shell">
        <section class="surface-card marketplace-hero-panel" data-aos="fade-up">
            <div class="marketplace-hero-copy">
                <span class="hero-badge"><i class="fa-solid fa-circle-check"></i> Verified farm marketplace</span>
                <h2>Buy fresh produce from growers who are ready to dispatch.</h2>
                <p class="muted-label">AgroVision Marketplace helps buyers compare crop quality, packing, harvest timing, and current market pulse data before placing an order or starting a relationship with a farmer.</p>

                <div class="marketplace-chip-row">
                    <span class="marketplace-inline-chip"><i class="fa-solid fa-truck-fast"></i> Faster sourcing</span>
                    <span class="marketplace-inline-chip"><i class="fa-solid fa-box-open"></i> Packing details visible</span>
                    <span class="marketplace-inline-chip"><i class="fa-solid fa-comments"></i> Buyer reviews included</span>
                </div>

                <div class="marketplace-stat-grid">
                    <article class="marketplace-stat-card">
                        <span>Live listings</span>
                        <strong data-countup="{{ $catalogStats['listings'] }}">{{ number_format($catalogStats['listings']) }}</strong>
                    </article>
                    <article class="marketplace-stat-card">
                        <span>Growers</span>
                        <strong data-countup="{{ $catalogStats['growers'] }}">{{ number_format($catalogStats['growers']) }}</strong>
                    </article>
                    <article class="marketplace-stat-card">
                        <span>Categories</span>
                        <strong data-countup="{{ $catalogStats['categories'] }}">{{ number_format($catalogStats['categories']) }}</strong>
                    </article>
                    <article class="marketplace-stat-card">
                        <span>Organic lots</span>
                        <strong data-countup="{{ $catalogStats['organic'] }}">{{ number_format($catalogStats['organic']) }}</strong>
                    </article>
                </div>
            </div>

            <div class="marketplace-hero-side">
                <div class="marketplace-signal-board">
                    <div class="marketplace-panel-heading">
                        <div>
                            <span class="section-kicker">Market pulse</span>
                            <h3>Today's mandi signals</h3>
                        </div>
                    </div>

                    <div class="marketplace-pulse-grid">
                        @foreach($marketPrices as $price)
                            <article class="marketplace-pulse-card">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <strong>{{ $price['crop'] }}</strong>
                                        <div class="small muted-label mt-1">{{ $price['market'] }}</div>
                                    </div>
                                    <span class="signal-chip {{ $price['trend'] }}">{{ $price['change'] }}%</span>
                                </div>
                                <div class="mt-3 fw-semibold">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        @if($spotlightCrops->isNotEmpty())
            <section class="surface-card marketplace-spotlight-panel" data-aos="fade-up">
                <div class="marketplace-panel-heading">
                    <div>
                        <span class="section-kicker">Featured supply</span>
                        <h3>Fresh arrivals buyers are watching this week.</h3>
                    </div>
                    <a href="#catalog" class="btn btn-outline-light btn-sm">Browse catalog</a>
                </div>

                <div class="row g-4">
                    @foreach($spotlightCrops as $crop)
                        <div class="col-lg-4">
                            <article class="marketplace-spotlight-card h-100">
                                <img src="{{ $crop->primary_image_url }}" alt="{{ $crop->title }}">
                                <div class="marketplace-spotlight-card__body">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <span class="badge-soft">{{ $crop->category->name }}</span>
                                        <span class="marketplace-rating-chip"><i class="fa-solid fa-star"></i> {{ number_format($crop->reviews_avg_rating ?? 0, 1) }}</span>
                                    </div>
                                    <h4>{{ $crop->title }}</h4>
                                    <p class="muted-label">{{ $crop->short_description ?: \Illuminate\Support\Str::limit($crop->description, 90) }}</p>
                                    <div class="marketplace-spotlight-meta">
                                        <span><i class="fa-solid fa-location-dot"></i> {{ $crop->location }}</span>
                                        <span><i class="fa-solid fa-box"></i> {{ $crop->stock }} {{ $crop->unit }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="crop-price">INR {{ number_format($crop->effective_price, 2) }}</div>
                                        <a href="{{ route('buyer.marketplace.show', $crop->slug) }}" class="btn btn-success btn-sm">View produce</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="surface-card marketplace-filter-panel" data-aos="fade-up">
            <div class="marketplace-panel-heading">
                <div>
                    <span class="section-kicker">Find inventory</span>
                    <h3>Search by produce, location, category, or price band.</h3>
                </div>
                @if($hasActiveFilters)
                    <a href="{{ route('buyer.marketplace.index') }}" class="btn btn-outline-light btn-sm">Clear filters</a>
                @endif
            </div>

            <form id="marketplaceFilterForm" action="{{ route('buyer.marketplace.index') }}" method="GET" class="marketplace-filter-form">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control" id="voiceSearchInput" name="search" placeholder="Search tomatoes, onions, organic, Pune..." value="{{ $filters['search'] ?? '' }}">
                            <button class="btn btn-outline-light voice-button" id="voiceSearchButton" type="button"><i class="fa-solid fa-microphone"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <select class="form-select" name="category">
                            <option value="">All categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(($filters['category'] ?? '') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input type="number" class="form-control" name="min_price" placeholder="Min price" value="{{ $filters['min_price'] ?? '' }}">
                    </div>
                    <div class="col-lg-2">
                        <input type="number" class="form-control" name="max_price" placeholder="Max price" value="{{ $filters['max_price'] ?? '' }}">
                    </div>
                    <div class="col-lg-2">
                        <select class="form-select" name="sort">
                            <option value="latest" @selected(($filters['sort'] ?? 'latest') === 'latest')>Latest first</option>
                            <option value="popular" @selected(($filters['sort'] ?? '') === 'popular')>Most viewed</option>
                            <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="marketplace-chip-row marketplace-chip-row--filters">
                @foreach($categories->take(6) as $category)
                    <a
                        href="{{ route('buyer.marketplace.index', ['category' => $category->id]) }}"
                        class="marketplace-filter-chip {{ ($filters['category'] ?? null) == $category->id ? 'active' : '' }}"
                    >
                        {{ $category->name }}
                        <span>{{ $category->approved_crops_count }}</span>
                    </a>
                @endforeach
            </div>

            @if(($filters['search'] ?? null) || ($selectedCategory?->name ?? null) || ($filters['min_price'] ?? null) || ($filters['max_price'] ?? null))
                <div class="marketplace-active-filters">
                    @if($filters['search'] ?? null)
                        <span class="marketplace-inline-chip">Search: {{ $filters['search'] }}</span>
                    @endif
                    @if($selectedCategory?->name ?? null)
                        <span class="marketplace-inline-chip">Category: {{ $selectedCategory->name }}</span>
                    @endif
                    @if($filters['min_price'] ?? null)
                        <span class="marketplace-inline-chip">Min: INR {{ $filters['min_price'] }}</span>
                    @endif
                    @if($filters['max_price'] ?? null)
                        <span class="marketplace-inline-chip">Max: INR {{ $filters['max_price'] }}</span>
                    @endif
                </div>
            @endif
        </section>

        <section class="marketplace-catalog-panel" id="catalog" data-aos="fade-up">
            <div class="marketplace-grid-head">
                <div>
                    <span class="section-kicker">Available produce</span>
                    <h3>{{ number_format($crops->total()) }} listings ready for discovery</h3>
                    <p class="muted-label mb-0">Browse verified produce, compare quality notes, and open the full crop profile before you buy.</p>
                </div>
                <div class="marketplace-grid-head__suggestions">
                    @foreach($searchSuggestions as $suggestion)
                        <a href="{{ route('buyer.marketplace.index', ['search' => $suggestion]) }}">{{ $suggestion }}</a>
                    @endforeach
                </div>
            </div>

            <div class="row g-4" id="marketplaceGrid">
                @include('buyer.marketplace.partials.grid', ['crops' => $crops, 'fallbackCrops' => $fallbackCrops])
            </div>

            <div class="mt-4" id="marketplacePagination">
                {{ $crops->links() }}
            </div>
        </section>
    </div>
@endsection
