@extends('layouts.app')

@php($pageTitle = $crop->title)
@php($pageSubtitle = 'Verified crop listing, grower details, delivery notes, and buyer reviews.')

@section('content')
    <div class="marketplace-shell">
        <section class="surface-card marketplace-detail-hero" data-aos="fade-up">
            <div class="marketplace-detail-media">
                <img src="{{ $crop->primary_image_url }}" alt="{{ $crop->title }}">
                <div class="marketplace-detail-overlay">
                    <span class="badge-soft">{{ $crop->category->name }}</span>
                    @if($crop->organic)
                        <span class="badge-soft">Organic</span>
                    @endif
                    <span class="badge-soft">{{ data_get($crop->meta, 'grade', 'Verified lot') }}</span>
                </div>
            </div>

            <div class="marketplace-detail-summary">
                <span class="hero-badge"><i class="fa-solid fa-shield-halved"></i> Verified produce listing</span>
                <h2>{{ $crop->title }}</h2>
                <p class="marketplace-detail-copy">{{ $crop->short_description ?: \Illuminate\Support\Str::limit($crop->description, 150) }}</p>

                <div class="marketplace-detail-statgrid">
                    <article>
                        <span>Rating</span>
                        <strong>{{ number_format((float) ($crop->reviews->avg('rating') ?? 0), 1) }}/5</strong>
                        <small>{{ $crop->reviews->count() }} buyer reviews</small>
                    </article>
                    <article>
                        <span>Available stock</span>
                        <strong>{{ $crop->stock }} {{ $crop->unit }}</strong>
                        <small>{{ data_get($crop->meta, 'min_order', 'Flexible MOQ') }}</small>
                    </article>
                    <article>
                        <span>Lead time</span>
                        <strong>{{ data_get($crop->meta, 'lead_time', 'Fast dispatch') }}</strong>
                        <small>{{ optional($crop->harvest_date)->format('d M Y') ?: 'Ready to dispatch' }}</small>
                    </article>
                </div>

                <div class="marketplace-detail-pricecard">
                    <div>
                        @if($crop->sale_price)
                            <small>Base price: INR {{ number_format((float) $crop->price, 2) }}/{{ $crop->unit }}</small>
                        @endif
                        <div class="crop-price">INR {{ number_format($crop->effective_price, 2) }}<em>/{{ $crop->unit }}</em></div>
                    </div>
                    <span class="marketplace-inline-chip">{{ data_get($crop->meta, 'packaging', 'Packed lot') }}</span>
                </div>

                <div class="marketplace-detail-actions">
                    @auth
                        @if(auth()->user()->hasRole('Buyer'))
                            <form action="{{ route('buyer.cart.store') }}" method="POST" class="marketplace-buy-form">
                                @csrf
                                <input type="hidden" name="crop_id" value="{{ $crop->id }}">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="number" min="1" name="quantity" value="1" class="form-control">
                                    </div>
                                    <div class="col-8">
                                        <button class="btn btn-success w-100">Add to cart</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('buyer.favorites.store', $crop) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-light w-100">Save to wishlist</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success w-100">Login to order</a>
                    @endauth
                </div>
            </div>
        </section>

        <div class="row g-4">
            <div class="col-lg-7">
                <section class="surface-card marketplace-detail-section" data-aos="fade-up">
                    <div class="marketplace-panel-heading">
                        <div>
                            <span class="section-kicker">About this lot</span>
                            <h3>Product overview</h3>
                        </div>
                    </div>
                    <p class="mb-0">{{ $crop->description }}</p>
                </section>

                <section class="surface-card marketplace-detail-section mt-4" data-aos="fade-up">
                    <div class="marketplace-panel-heading">
                        <div>
                            <span class="section-kicker">Listing specs</span>
                            <h3>Commercial details</h3>
                        </div>
                    </div>
                    <div class="marketplace-spec-grid">
                        <article>
                            <span>Grower</span>
                            <strong>{{ $crop->farmer->name }}</strong>
                        </article>
                        <article>
                            <span>Location</span>
                            <strong>{{ $crop->location ?: 'On request' }}</strong>
                        </article>
                        <article>
                            <span>Packaging</span>
                            <strong>{{ data_get($crop->meta, 'packaging', 'Packed lot') }}</strong>
                        </article>
                        <article>
                            <span>Certification</span>
                            <strong>{{ data_get($crop->meta, 'certification', 'Farmer verified') }}</strong>
                        </article>
                        <article>
                            <span>Harvest window</span>
                            <strong>{{ optional($crop->harvest_date)->format('d M Y') ?: 'Flexible' }}</strong>
                        </article>
                        <article>
                            <span>Organic status</span>
                            <strong>{{ $crop->organic ? 'Yes' : 'No' }}</strong>
                        </article>
                    </div>
                </section>
            </div>

            <div class="col-lg-5">
                <section class="surface-card marketplace-detail-section" data-aos="fade-up">
                    <div class="marketplace-panel-heading">
                        <div>
                            <span class="section-kicker">Why buyers choose it</span>
                            <h3>Trust markers</h3>
                        </div>
                    </div>
                    <div class="marketplace-trust-list">
                        <div class="marketplace-trust-item">
                            <strong>{{ data_get($crop->meta, 'grade', 'Verified') }}</strong>
                            <p class="mb-0 muted-label">Quality grade surfaced up front so buyers can compare lots quickly.</p>
                        </div>
                        <div class="marketplace-trust-item">
                            <strong>{{ data_get($crop->meta, 'lead_time', 'Fast dispatch') }}</strong>
                            <p class="mb-0 muted-label">Lead-time notes help trading teams plan dispatch and downstream delivery.</p>
                        </div>
                        <div class="marketplace-trust-item">
                            <strong>{{ data_get($crop->meta, 'min_order', 'Flexible MOQ') }}</strong>
                            <p class="mb-0 muted-label">Minimum order information keeps expectations clear before outreach or checkout.</p>
                        </div>
                    </div>
                </section>

                <section class="surface-card marketplace-detail-section mt-4" data-aos="fade-up">
                    <div class="marketplace-panel-heading">
                        <div>
                            <span class="section-kicker">Related produce</span>
                            <h3>Similar listings</h3>
                        </div>
                    </div>
                    @forelse($relatedCrops as $relatedCrop)
                        <div class="marketplace-related-item {{ !$loop->last ? 'mb-3 pb-3 border-bottom border-secondary-subtle' : '' }}">
                            <img src="{{ $relatedCrop->primary_image_url }}" alt="{{ $relatedCrop->title }}">
                            <div>
                                <a href="{{ route('buyer.marketplace.show', $relatedCrop->slug) }}" class="fw-semibold text-decoration-none">{{ $relatedCrop->title }}</a>
                                <div class="muted-label small mt-1">{{ $relatedCrop->location }}</div>
                                <div class="text-success fw-bold mt-2">INR {{ number_format($relatedCrop->effective_price, 2) }}/{{ $relatedCrop->unit }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="muted-label mb-0">No related listings available right now.</p>
                    @endforelse
                </section>
            </div>
        </div>

        <section class="surface-card marketplace-detail-section" data-aos="fade-up">
            <div class="marketplace-panel-heading">
                <div>
                    <span class="section-kicker">Buyer reviews</span>
                    <h3>Trust and quality feedback</h3>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    @forelse($crop->reviews as $review)
                        <article class="marketplace-review-item {{ !$loop->last ? 'mb-3 pb-3 border-bottom border-secondary-subtle' : '' }}">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <strong>{{ $review->buyer->name }}</strong>
                                    <div class="small muted-label">{{ $review->created_at->format('d M Y') }}</div>
                                </div>
                                <span class="marketplace-rating-chip"><i class="fa-solid fa-star"></i> {{ $review->rating }}/5</span>
                            </div>
                            <div class="fw-semibold mt-3">{{ $review->title }}</div>
                            <p class="mb-0 muted-label">{{ $review->review }}</p>
                        </article>
                    @empty
                        <p class="muted-label mb-0">No reviews yet for this listing.</p>
                    @endforelse
                </div>

                <div class="col-lg-5">
                    @auth
                        @if(auth()->user()->hasRole('Buyer'))
                            <form action="{{ route('buyer.reviews.store') }}" method="POST" class="marketplace-review-form">
                                @csrf
                                <input type="hidden" name="crop_id" value="{{ $crop->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <select class="form-select" name="rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i }} stars</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input class="form-control" name="title" placeholder="How was the quality?">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Review</label>
                                    <textarea class="form-control" rows="4" name="review" placeholder="Share your delivery, quality, or packing experience."></textarea>
                                </div>
                                <button class="btn btn-success w-100">Submit review</button>
                            </form>
                        @endif
                    @else
                        <div class="marketplace-guest-note">
                            <h5>Want to leave a review?</h5>
                            <p class="muted-label mb-3">Login as a buyer after purchase to share feedback and help other teams make better sourcing decisions.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-light w-100">Login</a>
                        </div>
                    @endauth
                </div>
            </div>
        </section>
    </div>
@endsection
