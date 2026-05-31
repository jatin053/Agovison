@extends('layouts.app')

@php($pageTitle = 'About AgroVision AI')
@php($pageSubtitle = 'A modern AgriTech platform inspired by smart farming dashboards, advisory ecosystems, and premium marketplace design.')

@section('content')
    <section class="hero-panel mb-4" data-aos="fade-up">
        <span class="hero-badge"><i class="fa-solid fa-seedling"></i> Mission-driven AgriTech SaaS</span>
        <h1>We design digital infrastructure for smarter agriculture.</h1>
        <p>AgroVision AI unifies precision farming, AI crop advisory, community workflows, live market pricing, buyer commerce, and expert consultation into one scalable platform for modern agricultural teams.</p>
    </section>

    <div class="row g-4 mb-4">
        @foreach($stats as $label => $value)
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <h6>{{ str_replace('_', ' ', ucfirst($label)) }}</h6>
                    <div class="metric-value">{{ $value }}</div>
                    <div class="metric-trend">Operational growth signal</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="surface-card h-100">
                <h3 class="mb-3">Platform pillars</h3>
                <div class="value-list">
                    <div class="value-list-item"><i class="fa-solid fa-brain text-success"></i> AI recommendation engines for crop planning and disease support.</div>
                    <div class="value-list-item"><i class="fa-solid fa-cloud text-success"></i> Weather, irrigation, and soil intelligence for field operations.</div>
                    <div class="value-list-item"><i class="fa-solid fa-store text-success"></i> Marketplace, checkout, reviews, and buyer trust workflows.</div>
                    <div class="value-list-item"><i class="fa-solid fa-users-viewfinder text-success"></i> Role-based dashboards for admins, farmers, buyers, and experts.</div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="surface-card h-100">
                <h3 class="mb-3">Market highlights</h3>
                <div class="market-price-grid">
                    @foreach($marketPrices as $price)
                        <div class="mini-card">
                            <span class="muted-label">{{ $price['market'] }}</span>
                            <strong>{{ $price['crop'] }}</strong>
                            <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
