@extends('layouts.auth', [
    'pageTitle' => 'Register',
    'pageTheme' => 'register',
    'eyebrow' => 'CREATE YOUR ACCOUNT',
    'heading' => 'Start your smart farming journey.',
    'subheading' => 'Register to access crop monitoring, yield prediction, disease insights, fertilizer recommendations, and weather-based farming tools.',
    'visualPill' => 'REGISTER FLOW',
    'visualTitle' => 'Grow with data-driven farming',
    'visualCopy' => 'Set up your account to unlock AI-powered recommendations and a cleaner workflow for modern agriculture.',
    'statLabelOne' => 'Mode',
    'statValueOne' => 'Register',
    'statLabelTwo' => 'Visual',
    'statValueTwo' => 'Smart Farming UI',
    'healthProgress' => 92,
    'healthValue' => '92%',
    'healthStatus' => 'Healthy',
    'moistureProgress' => 68,
    'moistureValue' => '68%',
    'moistureStatus' => 'Optimal',
    'chartValue' => '+18%',
    'chartLabel' => 'vs last season',
    'weatherValue' => '28°C',
    'weatherLabel' => 'Partly Cloudy',
])

@section('content')
    <form class="auth-form" method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="auth-field">
            <label class="auth-label" for="name">Full Name</label>
            <div class="auth-input-wrap">
                <span class="auth-input__icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4.2 0-7 2.1-7 5v1h14v-1c0-2.9-2.8-5-7-5Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input
                    class="auth-input @error('name') auth-input--error @enderror"
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    placeholder="Your full name"
                    required
                >
            </div>
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label class="auth-label" for="email">Email Address</label>
            <div class="auth-input-wrap">
                <span class="auth-input__icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3.5 6.5h17v11h-17zM4.5 7.5l7.5 6 7.5-6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input
                    class="auth-input @error('email') auth-input--error @enderror"
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    placeholder="you@example.com"
                    required
                >
            </div>
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label class="auth-label" for="password">Password</label>
            <div class="auth-input-wrap">
                <span class="auth-input__icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M7 10V7.8A5 5 0 0 1 12 3a5 5 0 0 1 5 4.8V10M6 10h12v10H6z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input
                    class="auth-input @error('password') auth-input--error @enderror"
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    placeholder="Create a strong password"
                    required
                >
                <button class="auth-input__toggle" type="button" data-password-toggle="password" aria-label="Show password">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label class="auth-label" for="password_confirmation">Confirm Password</label>
            <div class="auth-input-wrap">
                <span class="auth-input__icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M7 10V7.8A5 5 0 0 1 12 3a5 5 0 0 1 5 4.8V10M6 10h12v10H6z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input
                    class="auth-input"
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    placeholder="Repeat your password"
                    required
                >
                <button class="auth-input__toggle" type="button" data-password-toggle="password_confirmation" aria-label="Show password">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </button>
            </div>
        </div>

        <button class="auth-button" type="submit">
            <span class="auth-button__icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 4.5c-3.6.7-7 3.3-8.5 6.7-1.4 3.2-1 6.7 1.1 8.8 2.2 2.3 5.7 2.8 9.2 1.5 3.2-1.2 6.2-4 7.5-7 .9-2.2 1-5.4-.8-7.2C18.6 5 15.6 3.8 12 4.5Z" fill="currentColor"/>
                    <path d="M6.2 12.6c3.9-1 6.8-4.2 7.7-8.1 2.6.9 4.5 3.1 4.8 5.8-3.7.6-6.9 3.3-8.3 6.7-1.8-.1-3.4-1.1-4.2-2.5-.4-.7-.4-1.3 0-1.9Z" fill="#0b2207"/>
                </svg>
            </span>
            <span>Create Account</span>
        </button>
    </form>

    <p class="auth-meta">
        Already registered?
        <a class="auth-link" href="{{ route('login') }}">Sign in instead.</a>
    </p>
@endsection
