@extends('layouts.app')

@php($pageTitle = $auction->title)
@php($pageSubtitle = 'Monitor live bids, lot quality, and countdown timing for this crop auction.')

@section('content')
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="auction-card mb-4" data-aos="fade-up">
                <img class="auction-image" src="{{ $auction->crop->primary_image_url }}" alt="{{ $auction->title }}">
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <span class="badge-soft">{{ ucfirst($auction->status) }}</span>
                            <h2 class="mt-3 mb-1">{{ $auction->title }}</h2>
                            <div class="auction-meta">
                                <span>{{ $auction->crop->title }}</span>
                                <span>{{ $auction->crop->category->name }}</span>
                                <span>{{ $auction->farmer->name }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="muted-label">Closing in</div>
                            <div class="countdown" data-countdown="{{ $auction->ends_at->toIso8601String() }}"></div>
                        </div>
                    </div>
                    <p class="muted-label mt-3">{{ $auction->description }}</p>
                    <div class="dashboard-grid mt-4">
                        <div class="metric-card">
                            <h6>Current price</h6>
                            <div class="metric-value">INR {{ number_format($auction->current_price, 0) }}</div>
                        </div>
                        <div class="metric-card">
                            <h6>Bid increment</h6>
                            <div class="metric-value">INR {{ number_format((float) $auction->bid_increment, 0) }}</div>
                        </div>
                        <div class="metric-card">
                            <h6>Total bids</h6>
                            <div class="metric-value">{{ $auction->bids->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="surface-card" data-aos="fade-up">
                <h3 class="mb-3">Bid history</h3>
                <div class="metric-stack">
                    @foreach($auction->bids as $bid)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $bid->user->name }}</strong>
                                    <div class="small muted-label">{{ $bid->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="price-figure">INR {{ number_format((float) $bid->amount, 0) }}</div>
                            </div>
                            @if($bid->note)
                                <div class="small mt-2 muted-label">{{ $bid->note }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            @if(auth()->user()?->hasRole('Buyer'))
                <div class="surface-card mb-4" data-aos="fade-up">
                    <h3 class="mb-3">Place your bid</h3>
                    <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Bid amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Note</label>
                            <input type="text" name="note" class="form-control" placeholder="Optional delivery or quality note">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success w-100">Submit bid</button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="surface-card" data-aos="fade-up">
                <h3 class="mb-3">Related auctions</h3>
                <div class="metric-stack">
                    @foreach($relatedAuctions as $related)
                        <div class="mini-card">
                            <strong>{{ $related->title }}</strong>
                            <div class="small muted-label mt-2">{{ $related->farmer->name }}</div>
                            <a href="{{ route('auctions.show', $related) }}" class="btn btn-outline-light btn-sm mt-3">View</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
