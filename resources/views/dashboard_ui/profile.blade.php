@php
    $user = auth()->user();
    $userName = $user?->name ?: 'User';
    $userEmail = $user?->email ?: 'No email available';
    $nameParts = array_filter(preg_split('/\s+/', trim($userName)) ?: []);
    $userInitials = collect($nameParts)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
    $userInitials = $userInitials !== '' ? $userInitials : 'U';
    $joinedAt = optional($user?->created_at)->format('M d, Y') ?: 'Recently';
    $verifiedLabel = $user?->email_verified_at ? 'Verified Email' : 'Email Pending';
@endphp

@extends('dashboard_ui.layout')

@section('title', 'Profile')
@section('subtitle', 'Manage your personal details, farm profile, and active plan without leaving the shared dashboard shell.')

@section('content')
    <div class="dash-content-stack">
        <section class="dash-grid dash-grid--2-1">
            <article class="dash-card">
                <div class="dash-profile-hero">
                    <div class="dash-profile-hero__avatar">{{ $userInitials }}</div>
                    <div class="dash-profile-hero__copy">
                        <h2>{{ $userName }}</h2>
                        <p>{{ $user?->isAdmin() ? 'Administrator' : 'Farmer' }}</p>
                        <div class="dash-chip-row">
                            <span class="dash-chip dash-chip--green">{{ $verifiedLabel }}</span>
                            <span class="dash-chip dash-chip--green">Dashboard Access</span>
                        </div>
                    </div>
                </div>
                <div class="dash-detail-list">
                    <div><span>Email</span><strong>{{ $userEmail }}</strong></div>
                    <div><span>Role</span><strong>{{ $user?->isAdmin() ? 'Admin User' : 'Farmer User' }}</strong></div>
                    <div><span>Account Status</span><strong>Active</strong></div>
                    <div><span>Member Since</span><strong>{{ $joinedAt }}</strong></div>
                </div>
            </article>

            <article class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Your Plan</p><h2>AgroVision Premium</h2></div>
                </div>
                <ul class="dash-check-list">
                    <li>Advanced AI recommendations</li>
                    <li>Priority support</li>
                    <li>Custom reports</li>
                    <li>History up to 2 years</li>
                </ul>
                <a class="dash-button dash-button--primary dash-button--full" href="{{ route('features') }}">Manage Subscription</a>
            </article>
        </section>

        <section class="dash-grid dash-grid--3">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Personal Information</p><h2>Basic details</h2></div>
                </div>
                <div class="dash-detail-list">
                    <div><span>Full Name</span><strong>{{ $userName }}</strong></div>
                    <div><span>Email Address</span><strong>{{ $userEmail }}</strong></div>
                    <div><span>Role</span><strong>{{ $user?->isAdmin() ? 'Administrator' : 'Farmer' }}</strong></div>
                    <div><span>Joined</span><strong>{{ $joinedAt }}</strong></div>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Farm Information</p><h2>Operational profile</h2></div>
                </div>
                <div class="dash-detail-list">
                    <div><span>Farm Size</span><strong>12.5 acres</strong></div>
                    <div><span>Main Crops</span><strong>Wheat, Paddy, Maize</strong></div>
                    <div><span>Farm Location</span><strong>Chandigarh, India</strong></div>
                    <div><span>Irrigation Type</span><strong>Drip Irrigation</strong></div>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Support & Help</p><h2>Need assistance?</h2></div>
                </div>
                <div class="dash-list">
                    <div class="dash-list__item"><div><strong>Help Center</strong><p>Browse guides and articles.</p></div></div>
                    <div class="dash-list__item"><div><strong>Contact Support</strong><p>Reach our team for direct help.</p></div></div>
                    <div class="dash-list__item"><div><strong>Send Feedback</strong><p>Help us improve AgroVision.</p></div></div>
                </div>
                <a class="dash-button dash-button--ghost dash-button--full" href="{{ route('contact') }}">Chat with Support</a>
            </article>
        </section>
    </div>
@endsection
