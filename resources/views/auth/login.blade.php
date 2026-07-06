@extends('layouts.auth', [
    'pageTitle' => 'Log In',
    'pageTheme' => 'login',
    'eyebrow' => 'WELCOME BACK',
    'heading' => 'Access your smart farming dashboard.',
    'subheading' => 'Sign in to view crop insights, yield predictions, disease alerts, fertilizer recommendations, and real-time weather updates.',
    'visualPill' => 'LOGIN FLOW',
    'visualTitle' => 'Monitor your farm with clarity',
    'visualCopy' => 'Log in to access AI-powered reports, real-time insights, and personalized recommendations to help your crops thrive.',
    'statLabelOne' => 'Mode',
    'statValueOne' => 'Login',
    'statLabelTwo' => 'Visual',
    'statValueTwo' => 'Smart Farming UI',
    'healthProgress' => 92,
    'healthValue' => '92%',
    'healthStatus' => 'Healthy',
    'moistureProgress' => 66,
    'moistureValue' => '66%',
    'moistureStatus' => 'Optimal',
    'chartValue' => '+18%',
    'chartLabel' => 'vs last season',
    'weatherValue' => '28°C',
    'weatherLabel' => 'Partly Cloudy',
])

@section('content')
    <form class="auth-form" method="POST" action="{{ route('login.store') }}">
        @csrf

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
                    autocomplete="current-password"
                    placeholder="Enter your password"
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

        <div class="auth-row auth-row--between">
            <label class="auth-check">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <span class="auth-check__box">
                    <svg viewBox="0 0 16 16" aria-hidden="true">
                        <path d="m3.3 8.3 2.7 2.8 6-6.3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>Remember me</span>
            </label>

            @if (\Illuminate\Support\Facades\Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">Forgot password?</a>
            @else
                <span class="auth-link auth-link--muted">Forgot password?</span>
            @endif
        </div>

        <button class="auth-button" type="submit">
            <span class="auth-button__icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 4.5c-3.6.7-7 3.3-8.5 6.7-1.4 3.2-1 6.7 1.1 8.8 2.2 2.3 5.7 2.8 9.2 1.5 3.2-1.2 6.2-4 7.5-7 .9-2.2 1-5.4-.8-7.2C18.6 5 15.6 3.8 12 4.5Z" fill="currentColor"/>
                    <path d="M6.2 12.6c3.9-1 6.8-4.2 7.7-8.1 2.6.9 4.5 3.1 4.8 5.8-3.7.6-6.9 3.3-8.3 6.7-1.8-.1-3.4-1.1-4.2-2.5-.4-.7-.4-1.3 0-1.9Z" fill="#0b2207"/>
                </svg>
            </span>
            <span>Sign In</span>
        </button>

    </form>

    <p class="auth-meta">
        New to AgroVision?
        <a class="auth-link" href="{{ route('register') }}">Create an account.</a>
    </p>
@endsection
