@extends('layouts.app')

@php($pageTitle = 'Crop Auctions')
@php($pageSubtitle = 'Launch timed lots, track live bids, and discover premium produce through auction-driven trade.')

@section('content')
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="surface-card mb-4 marketplace-hero" data-aos="fade-up">
                <div>
                    <span class="hero-badge"><i class="fa-solid fa-gavel"></i> Auction-driven commerce</span>
                    <h3 class="mt-3 mb-2">Sell high-quality harvests with live bidding.</h3>
                    <p class="muted-label">Farmers can publish timed lots, buyers can place competitive bids, and the entire exchange stays visible with countdowns and price momentum.</p>
                </div>
                <div class="market-price-grid">
                    @foreach($marketPrices as $price)
                        <div class="mini-card">
                            <span class="muted-label">{{ $price['crop'] }}</span>
                            <strong>{{ $price['market'] }}</strong>
                            <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row g-4">
                @forelse($auctions as $auction)
                    <div class="col-md-6">
                        <div class="auction-card h-100" data-aos="fade-up">
                            <img class="auction-image" src="{{ $auction->crop->primary_image_url }}" alt="{{ $auction->title }}">
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge-soft">{{ ucfirst($auction->status) }}</span>
                                        <h4 class="mt-3 mb-1">{{ $auction->title }}</h4>
                                        <div class="auction-meta">
                                            <span>{{ $auction->crop->title }}</span>
                                            <span>{{ $auction->farmer->name }}</span>
                                            <span>{{ $auction->bids_count }} bids</span>
                                        </div>
                                    </div>
                                    <span class="countdown" data-countdown="{{ $auction->ends_at->toIso8601String() }}"></span>
                                </div>
                                <p class="muted-label mt-3">{{ \Illuminate\Support\Str::limit($auction->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <div class="muted-label">Current price</div>
                                        <div class="price-figure">INR {{ number_format($auction->current_price, 0) }}</div>
                                    </div>
                                    <a href="{{ route('auctions.show', $auction) }}" class="btn btn-success">View auction</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="surface-card text-center">
                            <h4 class="mb-2">No auctions live yet</h4>
                            <p class="muted-label mb-0">Create the first timed listing and start price discovery.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $auctions->links() }}
            </div>
        </div>
        <div class="col-xl-4">
            @if(auth()->user()?->hasRole('Farmer'))
                <div class="surface-card mb-4" data-aos="fade-up">
                    <h3 class="mb-3">Launch a new auction</h3>
                    <form action="{{ route('auctions.store') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Crop</label>
                            <select name="crop_id" class="form-select" required>
                                <option value="">Select crop</option>
                                @foreach($farmerCrops as $crop)
                                    <option value="{{ $crop->id }}">{{ $crop->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Auction title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Starting price</label>
                            <input type="number" name="starting_price" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bid increment</label>
                            <input type="number" name="bid_increment" class="form-control" value="50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Starts at</label>
                            <input type="datetime-local" name="starts_at" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ends at</label>
                            <input type="datetime-local" name="ends_at" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success w-100">Create auction</button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="surface-card" data-aos="fade-up">
                <h3 class="mb-3">Auction tips</h3>
                <ul class="insight-list mb-0">
                    <li>Use clear titles that mention grade, freshness, or lot quality.</li>
                    <li>Keep bid increments low enough to encourage activity in the first hour.</li>
                    <li>Time auctions near peak mandi volatility for stronger price discovery.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
