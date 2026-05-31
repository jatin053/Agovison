@extends('layouts.app')

@php($pageTitle = 'Contact AgroVision AI')
@php($pageSubtitle = 'Reach the AgriTech team for demos, advisory partnerships, marketplace onboarding, or enterprise deployments.')

@section('content')
    <div class="row g-4">
        <div class="col-xl-7">
            <div class="surface-card" data-aos="fade-up">
                <span class="hero-badge"><i class="fa-solid fa-headset"></i> Contact the team</span>
                <h3 class="mt-3 mb-2">Let's build better farm operations together.</h3>
                <p class="muted-label">Share your farm scale, marketplace needs, or deployment goals and we'll map the right AgroVision AI workflow for you.</p>
                <form action="{{ route('contact.store') }}" method="POST" class="row g-3 mt-1">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Full name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company or farm name</label>
                        <input type="text" name="company" class="form-control" placeholder="Optional">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success btn-lg">Send request</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="surface-card h-100" data-aos="fade-up">
                <h3 class="mb-3">Live market context</h3>
                <div class="metric-stack">
                    @foreach($marketPrices as $price)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $price['crop'] }}</strong>
                                <span class="signal-chip {{ $price['trend'] }}">{{ $price['change'] }}%</span>
                            </div>
                            <div class="muted-label mt-2">{{ $price['market'] }}</div>
                            <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
