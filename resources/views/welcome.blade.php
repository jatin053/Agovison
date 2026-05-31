@extends('layouts.app')

@php
    $pageTitle = __('platform.brand.name');
    $pageSubtitle = 'Smarter agriculture, clearer decisions, and connected agri commerce in one platform.';
    $statLabels = [
        'farmers' => 'Growers onboarded',
        'buyers' => 'Buyer connections',
        'crops' => 'Active crop listings',
        'orders' => 'Orders processed',
    ];
    $productIcons = [
        'fa-seedling',
        'fa-cloud-sun-rain',
        'fa-chart-line',
        'fa-warehouse',
        'fa-users-rays',
        'fa-truck-fast',
    ];
    $productDescriptions = [
        'Plan field operations, monitor growth cycles, and keep every crop record in one place.',
        'Blend local weather, market signals, and field data into daily decision support.',
        'Track performance, inventory movement, and crop demand with clearer visibility.',
        'Coordinate harvest, dispatch, and buyer fulfillment with fewer handoffs.',
        'Keep advisors, operators, and growers aligned through live collaboration.',
        'Connect inputs, auctions, and logistics inside one digital workflow.',
    ];
    $principles = [
        [
            'title' => 'Adaptive operations',
            'copy' => 'Adjust plans quickly with weather, demand, and crop-health signals in one workspace.',
        ],
        [
            'title' => 'Knowledge driven',
            'copy' => 'Turn AI guidance, field history, and expert input into practical daily actions.',
        ],
        [
            'title' => 'Built for collaboration',
            'copy' => 'Farmers, buyers, experts, and admins all work from the same live picture.',
        ],
    ];
    $marketHighlights = collect($marketPrices)->take(4);
    $featuredHighlights = $featuredCrops->take(3);
    $communityFeed = $communityHighlights->take(2);
    $auctionFeed = $liveAuctions->take(2);
@endphp

@section('content')

    <section class="agv-hero" id="home">
        <div class="agv-hero__copy" data-aos="fade-up">
            <span class="section-kicker">The next-generation in agricultural software</span>
            <h1>Smart software for everyday farming decisions.</h1>
            <p>AgroVision AI brings crop operations, weather intelligence, digital marketplaces, and expert collaboration into one connected platform for growers and agri businesses.</p>

            <div class="agv-hero__actions">
                <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="btn btn-success btn-lg">Get started</a>
                <a href="#products" class="btn btn-outline-light btn-lg">Discover our products</a>
            </div>

            <div class="agv-hero__signals">
                <span><i class="fa-solid fa-cloud-sun-rain"></i> {{ $weatherSnapshot['condition'] }} in Pune</span>
                <span><i class="fa-solid fa-gavel"></i> {{ $liveAuctions->count() }} live auction rooms</span>
                <span><i class="fa-solid fa-user-group"></i> {{ $communityHighlights->count() }} fresh community updates</span>
            </div>
        </div>

        <div class="agv-hero__panel" data-aos="fade-up" data-aos-delay="100">
            <div class="agv-hero-card agv-hero-card--primary">
                <div class="agv-hero-card__head">
                    <div>
                        <span class="public-site-tag">Today at a glance</span>
                        <h3>Field intelligence snapshot</h3>
                    </div>
                    <span class="agv-status-dot"></span>
                </div>

                <div class="agv-hero-metrics">
                    <div>
                        <span>Temperature</span>
                        <strong>{{ number_format((float) $weatherSnapshot['temperature'], 1) }} C</strong>
                    </div>
                    <div>
                        <span>Humidity</span>
                        <strong>{{ number_format((float) $weatherSnapshot['humidity'], 0) }}%</strong>
                    </div>
                    <div>
                        <span>Rain chance</span>
                        <strong>{{ number_format((float) $weatherSnapshot['rain_prediction'], 0) }}%</strong>
                    </div>
                    <div>
                        <span>Wind speed</span>
                        <strong>{{ number_format((float) $weatherSnapshot['wind_speed'], 0) }} km/h</strong>
                    </div>
                </div>
            </div>

            <div class="agv-market-grid">
                @forelse($marketHighlights as $price)
                    <article class="agv-market-card">
                        <span>{{ $price['market'] }}</span>
                        <strong>{{ $price['crop'] }}</strong>
                        <div>INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                    </article>
                @empty
                    <article class="agv-market-card">
                        <span>Market pulse</span>
                        <strong>Tomato</strong>
                        <div>INR 2,450 / Quintal</div>
                    </article>
                    <article class="agv-market-card">
                        <span>Market pulse</span>
                        <strong>Onion</strong>
                        <div>INR 1,980 / Quintal</div>
                    </article>
                @endforelse
            </div>

            <div class="agv-highlight-list">
                @forelse($featuredHighlights as $crop)
                    <a href="{{ route('buyer.marketplace.show', $crop->slug) }}" class="agv-highlight-item">
                        <img src="{{ $crop->primary_image_url }}" alt="{{ $crop->title }}">
                        <div>
                            <span>{{ $crop->category?->name ?? 'Featured crop' }}</span>
                            <strong>{{ $crop->title }}</strong>
                            <small>{{ $crop->location ?: 'Marketplace ready' }}</small>
                        </div>
                    </a>
                @empty
                    <div class="agv-highlight-item">
                        <img src="{{ asset('assets/images/crop-placeholder.svg') }}" alt="Featured crop">
                        <div>
                            <span>Featured crop</span>
                            <strong>Season-ready inventory</strong>
                            <small>Prepared for buyer discovery</small>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="agv-story" id="story">
        <div class="agv-story__content" data-aos="fade-up">
            <span class="section-kicker">Smart software for everyday use</span>
            <h2>We help farms make sharper decisions with less friction.</h2>
            <p>From weather-aware planning to digital crop sales and expert support, the platform brings the most important agricultural workflows into one clear operating view.</p>

            <div class="agv-principles">
                @foreach($principles as $principle)
                    <article class="agv-principle-card">
                        <h3>{{ $principle['title'] }}</h3>
                        <p>{{ $principle['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="agv-story__media" data-aos="fade-up" data-aos-delay="100">
            <div class="agv-operations-board">
                <div class="agv-operations-board__header">
                    <div>
                        <span class="public-site-tag">Operations board</span>
                        <h3>One view for crop, climate, and commerce.</h3>
                    </div>
                </div>

                <div class="agv-operations-board__stats">
                    @foreach($stats as $label => $value)
                        <div class="agv-operations-stat">
                            <span>{{ $statLabels[$label] ?? ucfirst($label) }}</span>
                            <strong data-countup="{{ $value }}">{{ number_format($value) }}</strong>
                        </div>
                    @endforeach
                </div>

                <div class="agv-operations-board__list">
                    <div class="agv-operations-line">
                        <span>Weather advisory</span>
                        <strong>{{ $weatherSnapshot['condition'] }}</strong>
                    </div>
                    <div class="agv-operations-line">
                        <span>Community momentum</span>
                        <strong>{{ $communityHighlights->count() }} active stories</strong>
                    </div>
                    <div class="agv-operations-line">
                        <span>Trading activity</span>
                        <strong>{{ $liveAuctions->count() }} lots in motion</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="agv-products" id="products" data-aos="fade-up">
        <div class="agv-section-head agv-section-head--light">
            <div>
                <span class="section-kicker">Our products</span>
                <h2>Connected modules for growers and agri teams.</h2>
            </div>
            <p>Each part of AgroVision AI is designed to simplify the daily work around crops, markets, weather, and collaboration.</p>
        </div>

        <div class="agv-product-grid">
            @forelse($categories->take(6) as $category)
                <article class="agv-product-card">
                    <div class="agv-product-card__icon">
                        <i class="fa-solid {{ $productIcons[$loop->index % count($productIcons)] }}"></i>
                    </div>
                    <span class="public-site-tag">{{ strtoupper($category->slug ?: 'module') }}</span>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description ?: $productDescriptions[$loop->index % count($productDescriptions)] }}</p>
                    <a href="{{ route('buyer.marketplace.index', ['category' => $category->id]) }}">Explore module</a>
                </article>
            @empty
                @foreach($productDescriptions as $index => $description)
                    <article class="agv-product-card">
                        <div class="agv-product-card__icon">
                            <i class="fa-solid {{ $productIcons[$index % count($productIcons)] }}"></i>
                        </div>
                        <span class="public-site-tag">Module {{ $index + 1 }}</span>
                        <h3>AgroVision workflow</h3>
                        <p>{{ $description }}</p>
                        <a href="{{ route('buyer.marketplace.index') }}">Explore module</a>
                    </article>
                @endforeach
            @endforelse
        </div>
    </section>

    <section class="agv-proof" data-aos="fade-up">
        <div class="agv-proof__copy">
            <span class="section-kicker">Built for next-generation teams</span>
            <h2>Clearer visibility for growers, buyers, and experts.</h2>
            <p>The platform keeps field activity, inventory, pricing, and collaboration connected so teams can respond faster and plan with more confidence.</p>
            <div class="agv-proof__actions">
                <a href="{{ route('about') }}" class="btn btn-success">See who we are</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light">Talk to the team</a>
            </div>
        </div>

        <div class="agv-proof__grid">
            @foreach($stats as $label => $value)
                <article class="agv-proof-card">
                    <span>{{ $statLabels[$label] ?? ucfirst($label) }}</span>
                    <strong data-countup="{{ $value }}">{{ number_format($value) }}</strong>
                    <p>Live activity reflected through the AgroVision ecosystem.</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="agv-network" id="network" data-aos="fade-up">
        <div class="agv-section-head agv-section-head--center">
            <div>
                <span class="section-kicker">AgroVision network</span>
                <h2>Connected regions, markets, and field teams in one view.</h2>
            </div>
            <p>Use one platform to keep agronomy, trading, and operational updates aligned across your growing network.</p>
        </div>

        <div class="agv-network-map">
            <span class="agv-network-marker agv-network-marker--one"></span>
            <span class="agv-network-marker agv-network-marker--two"></span>
            <span class="agv-network-marker agv-network-marker--three"></span>
            <span class="agv-network-marker agv-network-marker--four"></span>
            <span class="agv-network-marker agv-network-marker--five"></span>
        </div>

        <div class="agv-network-stats">
            @foreach($stats as $label => $value)
                <article class="agv-network-card">
                    <strong data-countup="{{ $value }}">{{ number_format($value) }}</strong>
                    <span>{{ $statLabels[$label] ?? ucfirst($label) }}</span>
                </article>
            @endforeach
        </div>
    </section>

    <section class="agv-news" id="news" data-aos="fade-up">
        <div class="agv-section-head">
            <div>
                <span class="section-kicker">AgroVision news</span>
                <h2>Fresh updates from the field and live market.</h2>
            </div>
            <a href="{{ route('community.index') }}" class="btn btn-outline-light btn-sm">All updates</a>
        </div>

        <div class="agv-news-grid">
            @forelse($communityFeed as $post)
                <article class="agv-news-card">
                    <span class="public-site-tag">Community</span>
                    <h3>{{ $post->title ?: 'Farmer field update' }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($post->body, 120) }}</p>
                    <div class="agv-news-meta">
                        <span>{{ $post->user->name }}</span>
                        <span>{{ $post->all_comments_count }} comments</span>
                    </div>
                </article>
            @empty
                <article class="agv-news-card">
                    <span class="public-site-tag">Community</span>
                    <h3>Grower insights arrive in one feed</h3>
                    <p>Share crop progress, ask field questions, and keep the entire farming network in sync.</p>
                    <div class="agv-news-meta">
                        <span>AgroVision network</span>
                        <span>Daily updates</span>
                    </div>
                </article>
            @endforelse

            @forelse($auctionFeed as $auction)
                <article class="agv-news-card agv-news-card--accent">
                    <span class="public-site-tag">Live market</span>
                    <h3>{{ $auction->title }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($auction->description ?: 'Competitive crop bidding is active for this listing.', 120) }}</p>
                    <div class="agv-news-meta">
                        <span>{{ $auction->farmer->name }}</span>
                        <span class="countdown" data-countdown="{{ $auction->ends_at?->toIso8601String() }}"></span>
                    </div>
                </article>
            @empty
                <article class="agv-news-card agv-news-card--accent">
                    <span class="public-site-tag">Live market</span>
                    <h3>Timed auctions keep demand visible</h3>
                    <p>Launch lots, monitor bids, and respond quickly as buyers compete for quality produce.</p>
                    <div class="agv-news-meta">
                        <span>Marketplace engine</span>
                        <span>Always on</span>
                    </div>
                </article>
            @endforelse
        </div>
    </section>

    <section class="agv-cta" data-aos="fade-up">
        <div>
            <span class="section-kicker">Ready to grow smarter?</span>
            <h2>Bring agronomy, weather, and digital commerce into one product.</h2>
            <p>Start with a cleaner operating view for field teams, buyers, and advisors.</p>
        </div>

        <div class="agv-cta__actions">
            <a href="{{ route('register') }}" class="btn btn-success btn-lg">Create account</a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Book a demo</a>
        </div>
    </section>
@endsection
