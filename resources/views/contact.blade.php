@php
    $brandName = config('app.name', 'AgroVision');

    if ($brandName === 'Laravel') {
        $brandName = 'AgroVision';
    }

    $dashboardUrl = auth()->check() ? route('dashboard') : null;

    $images = [
        'hero' => 'https://images.pexels.com/photos/4975400/pexels-photo-4975400.jpeg?auto=compress&cs=tinysrgb&w=2200',
        'cta' => 'https://images.pexels.com/photos/34182309/pexels-photo-34182309.jpeg?auto=compress&cs=tinysrgb&w=2200',
        'field' => 'https://images.pexels.com/photos/34182316/pexels-photo-34182316.jpeg?auto=compress&cs=tinysrgb&w=2200',
        'thumbOne' => 'https://images.pexels.com/photos/17797257/pexels-photo-17797257.jpeg?auto=compress&cs=tinysrgb&w=600',
        'thumbTwo' => 'https://images.pexels.com/photos/4975400/pexels-photo-4975400.jpeg?auto=compress&cs=tinysrgb&w=600',
        'thumbThree' => 'https://images.pexels.com/photos/34182309/pexels-photo-34182309.jpeg?auto=compress&cs=tinysrgb&w=600',
        'thumbFour' => 'https://images.pexels.com/photos/34182316/pexels-photo-34182316.jpeg?auto=compress&cs=tinysrgb&w=600',
        'thumbFive' => 'https://images.pexels.com/photos/17797257/pexels-photo-17797257.jpeg?auto=compress&cs=tinysrgb&w=600',
        'thumbSix' => 'https://images.pexels.com/photos/4975400/pexels-photo-4975400.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    $heroStats = [
        ['title' => 'Expert Support', 'copy' => 'Real people, real help', 'icon' => 'support'],
        ['title' => 'Quick Response', 'copy' => 'We reply within 24hrs', 'icon' => 'clock'],
        ['title' => 'Trusted by Farmers', 'copy' => 'Across 1000+ farms', 'icon' => 'trust'],
    ];
    $serviceLinks = array_map(
        fn ($label) => [
            'label' => $label,
            'href' => route('services') . '#' . \Illuminate\Support\Str::slug($label),
        ],
        [
            'Crop Recommendation',
            'Yield Prediction',
            'Disease Detection',
            'Fertilizer Recommendation',
            'Weather Forecast',
            'Farm Reports',
        ]
    );

    $contactCards = [
        ['title' => 'Address', 'lines' => ['AgroVision Smart Farming Project,', 'Himachal Pradesh, India'], 'icon' => 'pin'],
        ['title' => 'Email Us', 'lines' => ['hello@agrovision.com', 'support@agrovision.com'], 'icon' => 'mail'],
        ['title' => 'Call Us', 'lines' => ['+91 70187 41392'], 'icon' => 'phone'],
        ['title' => 'Working Hours', 'lines' => ['Mon - Sat : 9:00 AM - 6:00 PM', 'Sunday : Closed'], 'icon' => 'time'],
        ['title' => 'Support', 'lines' => ['support@agrovision.com', 'We are here to help!'], 'icon' => 'headset'],
    ];

    $helpCards = [
        ['title' => 'Product Support', 'copy' => 'Get help with our platform & features', 'icon' => 'box'],
        ['title' => 'Technical Help', 'copy' => 'Resolve technical issues & errors', 'icon' => 'gear'],
        ['title' => 'Account & Billing', 'copy' => 'Manage your account & subscriptions', 'icon' => 'wallet'],
        ['title' => 'Partnerships', 'copy' => 'Let us work together for smarter farming', 'icon' => 'users'],
        ['title' => 'Training & Demo', 'copy' => 'Request a demo or training session', 'icon' => 'network'],
        ['title' => 'Feedback', 'copy' => 'Share your feedback to help us improve', 'icon' => 'heart'],
    ];

    $faqs = [
        ['question' => 'How can I get support for my account?', 'answer' => 'You can email us at support@agrovision.com or call our support team during working hours.'],
        ['question' => 'What are your working hours?', 'answer' => 'Our team is available Monday to Saturday from 9:00 AM to 6:00 PM.'],
        ['question' => 'Do you offer product training?', 'answer' => 'Yes, we offer guided demos and training sessions for farmers, teams, and partners.'],
        ['question' => 'How can I schedule a demo?', 'answer' => 'Use the form on this page or click Book a Demo and our team will contact you.'],
        ['question' => 'Where is AgroVision located?', 'answer' => 'AgroVision is based in Himachal Pradesh, India.'],
    ];

    $footerLinks = [
        ['label' => 'Home', 'href' => route('home')],
        ['label' => 'About Us', 'href' => route('about')],
        ['label' => 'Features', 'href' => route('features')],
    ];

    if ($dashboardUrl) {
        $footerLinks[] = ['label' => 'Dashboard', 'href' => $dashboardUrl];
    }

    $footerLinks[] = ['label' => 'Contact Us', 'href' => route('contact')];

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact {{ $brandName }} | Smart Farming Support</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|space-grotesk:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
    </head>
    <body class="home-body contact-page-body" data-page="contact">
        <div id="top"></div>

        <div class="site-topbar contact-topbar">
            <div class="site-container site-topbar__inner">
                <div class="site-topbar__group">
                    <a class="site-topbar__link" href="#location">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 3.5c-3.1 0-5.5 2.4-5.5 5.4 0 4.2 5.5 11.6 5.5 11.6s5.5-7.4 5.5-11.6c0-3-2.4-5.4-5.5-5.4Zm0 7.5a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span>AgroVision Smart Farming Project, Himachal Pradesh</span>
                    </a>
                    <a class="site-topbar__link" href="tel:+917018741392">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m6.8 4.9 2.4-.7a1.3 1.3 0 0 1 1.5.7l1.1 2.7a1.3 1.3 0 0 1-.3 1.4l-1.3 1.3a13.9 13.9 0 0 0 3.5 3.5l1.3-1.3a1.3 1.3 0 0 1 1.4-.3l2.7 1.1a1.3 1.3 0 0 1 .7 1.5l-.7 2.4a1.3 1.3 0 0 1-1.3 1C11.2 19.5 4.5 12.8 4.5 6.2a1.3 1.3 0 0 1 1-1.3Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>+91 70187 41392</span>
                    </a>
                    <a class="site-topbar__link" href="mailto:hello@agrovision.com">
                        <span class="site-topbar__mini-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4.5 6.5h15v11h-15z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                <path d="m5.6 7.4 6.4 5 6.4-5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span>hello@agrovision.com</span>
                    </a>
                </div>

                <div class="site-topbar__group site-topbar__group--right">
                    <button class="site-topbar__lang" type="button">
                        <span>English</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m7 10 5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="site-socials" aria-label="Social links">
                        <a href="#contact-form" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/></svg></a>
                        <a href="#contact-form" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/></svg></a>
                        <a href="#contact-form" aria-label="LinkedIn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/></svg></a>
                        <a href="#contact-form" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.8A2.7 2.7 0 0 0 4.8 7.5v9a2.7 2.7 0 0 0 2.7 2.7h9a2.7 2.7 0 0 0 2.7-2.7v-9a2.7 2.7 0 0 0-2.7-2.7Zm9.7 1.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8A3.2 3.2 0 1 0 12 15.2 3.2 3.2 0 0 0 12 8.8Z" fill="currentColor"/></svg></a>
                        <a href="#contact-form" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 8.5a3 3 0 0 0-2.1-2.1C17 6 12 6 12 6s-5 0-6.9.4A3 3 0 0 0 3 8.5 31.7 31.7 0 0 0 2.6 12 31.7 31.7 0 0 0 3 15.5a3 3 0 0 0 2.1 2.1C7 18 12 18 12 18s5 0 6.9-.4a3 3 0 0 0 2.1-2.1c.3-1.1.4-2.3.4-3.5s-.1-2.4-.4-3.5ZM10 15V9l5 3-5 3Z" fill="currentColor"/></svg></a>
                    </div>
                </div>
            </div>
        </div>

        <header class="site-header contact-header" data-header>
            <div class="site-container site-header__inner">
                <a class="site-brand" href="{{ route('home') }}">
                    <span class="site-brand__mark">
                        <svg viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                            <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/>
                            <path d="M31.2 12.3c1.5 7.1-1.6 14.6-8 19.2-3.8 2.8-8.5 4.3-13.2 4.2 4.6 2.7 10.9 3 16.4.9 5.4-2.1 10.3-6.9 12.5-12.2 2.1-5 1.4-10-1.7-13.1-1.8-1.7-3.9-2.7-6-3Z" fill="#8edb57" opacity=".72"/>
                        </svg>
                    </span>
                    <span class="site-brand__copy">
                        <strong>{{ $brandName }}</strong>
                        <small>Smart Farming. Built on Trust</small>
                    </span>
                </a>

                <button class="site-nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="site-header__menu" id="site-nav" data-nav-panel>
                    <nav class="site-nav" aria-label="Primary">
                        <a class="site-nav__link" href="{{ route('home') }}">Home</a>
                        <a class="site-nav__link" href="{{ route('about') }}">About</a>
                        <a class="site-nav__link" href="{{ route('features') }}">Features</a>
                        @auth
                            <a class="site-nav__link" href="{{ route('dashboard') }}">Dashboard</a>
                        @endauth
                        @include('partials.services-dropdown', ['serviceLinks' => $serviceLinks])
                        <a class="site-nav__link is-active" href="{{ route('contact') }}">Contact</a>
                    </nav>

                    <div class="site-header__actions">
                        @include('partials.public-auth-actions')
                    </div>
                </div>
            </div>
        </header>

        <main class="contact-main">
            <section class="contact-hero" data-section="contact">
                <div class="contact-hero__media" aria-hidden="true">
                    <img src="{{ $images['hero'] }}" alt="Farmer with tablet in a green field" loading="eager">
                </div>
                <div class="contact-hero__overlay"></div>
                <div class="site-container contact-hero__inner">
                    <div class="contact-hero__copy" data-reveal>
                        <h1>Let's Connect for <span>Smarter Farming</span></h1>
                        <p>
                            We are here to help you grow better with technology, insights, and dedicated support.
                            Reach out to our team for any questions, partnerships, or support.
                        </p>

                        <div class="contact-hero__stats">
                            @foreach ($heroStats as $stat)
                                <article class="contact-hero__stat">
                                    <span class="contact-icon contact-icon--soft">
                                        @if ($stat['icon'] === 'support')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 13a7 7 0 0 1 14 0v3a2 2 0 0 1-2 2h-2M5 13v3a2 2 0 0 0 2 2h1M9 18h6M9 10a3 3 0 0 1 6 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @elseif ($stat['icon'] === 'clock')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7v5l3 3M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.8 18 6v5.5c0 4-2.5 7.3-6 8.7-3.5-1.4-6-4.7-6-8.7V6l6-2.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="m9 12 2 2 4-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @endif
                                    </span>
                                    <div>
                                        <strong>{{ $stat['title'] }}</strong>
                                        <small>{{ $stat['copy'] }}</small>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    <div class="contact-hero__mark" aria-hidden="true">
                        <span class="site-brand__mark">
                            <svg viewBox="0 0 48 48"><path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/><path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/></svg>
                        </span>
                    </div>
                </div>
            </section>

            <section class="contact-section contact-section--lead">
                <div class="site-container contact-grid">
                    <form class="contact-card contact-form" id="contact-form" action="{{ route('contact.store') }}" method="post" data-reveal>
                        @csrf
                        <h2>
                            <span class="contact-title-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 9.3v7.2M12 12c-1.9-.3-3.4-1.6-4-3.4M12 13.8c1.9-.3 3.4-1.6 4-3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span>
                            Send Us a Message
                        </h2>

                        @if (session('status'))
                            <p class="auth-success contact-field--full">{{ session('status') }}</p>
                        @endif

                        <label class="contact-field contact-field--full">
                            <span>Full Name</span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                            @error('name')
                                <small class="auth-error">{{ $message }}</small>
                            @enderror
                        </label>
                        <label class="contact-field">
                            <span>Email Address</span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            @error('email')
                                <small class="auth-error">{{ $message }}</small>
                            @enderror
                        </label>
                        <label class="contact-field">
                            <span>Phone Number</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                            @error('phone')
                                <small class="auth-error">{{ $message }}</small>
                            @enderror
                        </label>
                        <label class="contact-field contact-field--full">
                            <span>Subject</span>
                            <select name="subject" required>
                                <option value="">How can we help you?</option>
                                @foreach (['Product Support', 'Book a Demo', 'Partnership', 'Technical Help'] as $subject)
                                    <option value="{{ $subject }}" @selected(old('subject') === $subject)>{{ $subject }}</option>
                                @endforeach
                            </select>
                            @error('subject')
                                <small class="auth-error">{{ $message }}</small>
                            @enderror
                        </label>
                        <label class="contact-field contact-field--full">
                            <span>Message</span>
                            <textarea name="message" placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="auth-error">{{ $message }}</small>
                            @enderror
                        </label>

                        <div class="contact-form__footer contact-field--full">
                            <button class="site-button" type="submit">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12 20 4l-7 16-2.2-6.8L4 12Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span>Send Message</span>
                            </button>
                            <small>We will get back to you as soon as possible.</small>
                        </div>
                    </form>

                    <aside class="contact-info" data-reveal>
                        <h2>
                            <span class="contact-title-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg></span>
                            Contact Information
                        </h2>

                        <div class="contact-info__list">
                            @foreach ($contactCards as $card)
                                <article class="contact-info__card">
                                    <span class="contact-icon">
                                        @if ($card['icon'] === 'pin')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.5c-3.1 0-5.5 2.4-5.5 5.4 0 4.2 5.5 11.6 5.5 11.6s5.5-7.4 5.5-11.6c0-3-2.4-5.4-5.5-5.4Zm0 7.5a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2Z" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>
                                        @elseif ($card['icon'] === 'mail')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 6.5h15v11h-15z" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="m5.6 7.4 6.4 5 6.4-5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                        @elseif ($card['icon'] === 'phone')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6.8 4.9 2.4-.7a1.3 1.3 0 0 1 1.5.7l1.1 2.7a1.3 1.3 0 0 1-.3 1.4l-1.3 1.3a13.9 13.9 0 0 0 3.5 3.5l1.3-1.3a1.3 1.3 0 0 1 1.4-.3l2.7 1.1a1.3 1.3 0 0 1 .7 1.5l-.7 2.4a1.3 1.3 0 0 1-1.3 1C11.2 19.5 4.5 12.8 4.5 6.2a1.3 1.3 0 0 1 1-1.3Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                        @elseif ($card['icon'] === 'time')
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7v5l3 3M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 13a7 7 0 0 1 14 0v3a2 2 0 0 1-2 2h-2M5 13v3a2 2 0 0 0 2 2h1M9 18h6M9 10a3 3 0 0 1 6 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        @endif
                                    </span>
                                    <div>
                                        <strong>{{ $card['title'] }}</strong>
                                        @foreach ($card['lines'] as $line)
                                            <p>{{ $line }}</p>
                                        @endforeach
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </aside>
                </div>
            </section>

            <section class="contact-section">
                <div class="site-container">
                    <div class="contact-heading" data-reveal>
                        <span class="contact-title-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg></span>
                        <h2>How Can We Help?</h2>
                        <p>Choose a topic below and our team will assist you better.</p>
                    </div>

                    <div class="contact-help-grid">
                        @foreach ($helpCards as $card)
                            <article class="contact-help-card" data-reveal>
                                <span class="contact-icon contact-icon--round">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        @if ($card['icon'] === 'box')
                                            <path d="m4 8 8-4 8 4-8 4-8-4Zm0 0v8l8 4 8-4V8M12 12v8" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                        @elseif ($card['icon'] === 'gear')
                                            <path d="M12 15.5A3.5 3.5 0 1 0 12 8a3.5 3.5 0 0 0 0 7.5Zm0-12v2M12 18.5v2M4.7 6.2l1.4 1.4M17.9 16.8l1.4 1.4M3.5 12h2M18.5 12h2M4.7 17.8l1.4-1.4M17.9 7.2l1.4-1.4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                        @elseif ($card['icon'] === 'wallet')
                                            <path d="M4.5 7.5h15v10h-15zM16 12h3.5M7 7.5V5.8h9v1.7" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        @elseif ($card['icon'] === 'users')
                                            <path d="M9 11a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm6 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3ZM4 19c0-2.2 2.3-4 5-4s5 1.8 5 4M11 19c0-1.9 2-3.4 4.5-3.4S20 17.1 20 19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        @elseif ($card['icon'] === 'network')
                                            <path d="M12 5v4M12 15v4M5 12h4M15 12h4M8.5 8.5l-2-2M15.5 15.5l2 2M15.5 8.5l2-2M8.5 15.5l-2 2M10 10h4v4h-4z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                        @else
                                            <path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.7A4 4 0 0 1 19 10c0 5.6-7 10-7 10Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                        @endif
                                    </svg>
                                </span>
                                <h3>{{ $card['title'] }}</h3>
                                <p>{{ $card['copy'] }}</p>
                                <a href="#contact-form">Contact Now <span>-></span></a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="contact-section contact-section--split">
                <div class="site-container contact-lower-grid">
                    <div class="contact-map-block" id="location" data-reveal>
                        <h2><span class="contact-title-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg></span> Our Location</h2>
                        <div class="contact-map">
                            <iframe title="AgroVision Himachal Pradesh location map" src="https://maps.google.com/maps?q=Himachal%20Pradesh%20India&t=&z=8&ie=UTF8&iwloc=&output=embed" loading="lazy"></iframe>
                            <article class="contact-map__card">
                                <strong>AgroVision Headquarters</strong>
                                <p>AgroVision Smart Farming Project, Himachal Pradesh, India</p>
                                <a class="site-button" href="https://maps.google.com/?q=Himachal%20Pradesh%20India" target="_blank" rel="noreferrer">Get Directions <span>-></span></a>
                            </article>
                        </div>
                    </div>

                    <div class="contact-faq" data-reveal>
                        <h2><span class="contact-title-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.2c-4 2.5-6.1 6.3-6.1 10.1 0 3.7 2.6 6.1 6.1 6.1s6.1-2.4 6.1-6.1C18.1 10.5 16 6.7 12 4.2Z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg></span> Frequently Asked Questions</h2>
                        <div class="contact-faq__list">
                            @foreach ($faqs as $faq)
                                <details class="contact-faq__item" @if ($loop->first) open @endif>
                                    <summary>{{ $faq['question'] }}</summary>
                                    <p>{{ $faq['answer'] }}</p>
                                </details>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="contact-section">
                <div class="site-container">
                    <div class="contact-demo" data-reveal>
                        <img src="{{ $images['cta'] }}" alt="Farmers operating drone technology in a field" loading="lazy">
                        <div class="contact-demo__icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3v3M17 3v3M4.5 8h15M6 5h12a1.5 1.5 0 0 1 1.5 1.5v12A1.5 1.5 0 0 1 18 20H6a1.5 1.5 0 0 1-1.5-1.5v-12A1.5 1.5 0 0 1 6 5Zm5 7h5M11 16h3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </div>
                        <div>
                            <h2>Book a Demo or Request Support</h2>
                            <p>See how AgroVision can transform your farming operations.</p>
                            <div class="contact-demo__actions">
                                <a class="site-button site-button--light" href="#contact-form">Book a Demo</a>
                                <a class="site-button site-button--ghost-light" href="#contact-form">Request Support</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="agro-long-section agro-long-section--alt">
                <div class="site-container">
                    <div class="agro-long-section__header" data-reveal>
                        <span class="section-chip section-chip--soft">Support Process</span>
                        <h2>How AgroVision handles your message after you contact us.</h2>
                        <p>Whether you are asking for a demo, reporting an issue, or requesting help with a farm module, the support flow is designed to be clear and useful.</p>
                    </div>

                    <div class="agro-long-timeline" data-reveal>
                        <article class="agro-long-step">
                            <span>01</span>
                            <div>
                                <h3>You send your query</h3>
                                <p>Use the contact form with your name, email, phone number, subject, and message. If the query is about a report, mention the crop, location, and module name so support can understand it quickly.</p>
                            </div>
                        </article>
                        <article class="agro-long-step">
                            <span>02</span>
                            <div>
                                <h3>We review the module context</h3>
                                <p>For user support, the team can check whether the issue is related to location, weather, disease image upload, soil profile, fertilizer rules, yield input, or farm reports.</p>
                            </div>
                        </article>
                        <article class="agro-long-step">
                            <span>03</span>
                            <div>
                                <h3>You get a practical response</h3>
                                <p>The response focuses on the next useful step: correct a form input, check API key setup, run migration, review reports, or improve the farm data entered in the dashboard.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="contact-newsletter">
                <div class="site-container contact-newsletter__inner">
                    <div class="contact-newsletter__leaf" aria-hidden="true">
                        <svg viewBox="0 0 96 96">
                            <path d="M48 14c-20 8-30 23-30 39 0 18 12 29 30 29s30-11 30-29c0-16-10-31-30-39Z" fill="#8ddc57"/>
                            <path d="M48 24v46M48 42c-10-1-18-8-22-17M48 52c12-2 21-9 25-20" fill="none" stroke="#0c4b20" stroke-width="5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Stay Updated with AgroVision</h2>
                        <p>Subscribe to get the latest farming tips, product updates, and insights delivered straight to your inbox.</p>
                    </div>
                    <form class="contact-newsletter__form" action="#" method="get">
                        <input type="email" name="email" placeholder="Enter your email" aria-label="Email address">
                        <button class="site-button" type="button">Subscribe <span>-></span></button>
                        <small>No spam. Unsubscribe anytime.</small>
                    </form>
                </div>
            </section>
        </main>

        <footer class="site-footer site-footer--contact" id="contact">
            <div class="site-container site-footer__main contact-footer__main">
                <div class="site-footer__brand">
                    <a class="site-brand site-brand--footer" href="{{ route('home') }}">
                        <span class="site-brand__mark">
                            <svg viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M23.9 9.2c-6.2 1.2-12 5.8-14.5 11.5-2.5 5.6-1.8 11.4 1.9 15.2 3.7 3.8 9.8 4.8 15.8 2.6 5.5-2 10.6-6.8 12.9-12.1 2.3-5.5 1.5-11.1-2.2-14.5-3.5-3.3-8.7-4.2-13.9-2.7Z" fill="currentColor"/>
                                <path d="M12.7 26.9c6.6-1.8 11.5-7.1 12.9-13.9 4.5 1.5 7.7 5.4 8.2 10-6.3.9-11.8 5.6-14.2 11.5-3.1-.3-5.8-1.9-6.9-4.4-.7-1.3-.7-2.3 0-3.2Z" fill="#083616"/>
                            </svg>
                        </span>
                        <span class="site-brand__copy">
                            <strong>{{ $brandName }}</strong>
                            <small>Smart Farming Support</small>
                        </span>
                    </a>
                    <p class="site-footer__brand-copy">Empowering farmers with smart technology for better productivity, sustainability, and higher yields.</p>
                    <div class="site-socials site-socials--footer">
                        <a href="#contact-form" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.2h2.1V5h-2.5c-2.9 0-4.4 1.7-4.4 4.7v2.1H6.3v3.1h2.4V21h3.4v-6.1h2.8l.5-3.1h-3.3V10c0-1.1.4-1.8 1.4-1.8Z" fill="currentColor"/></svg></a>
                        <a href="#contact-form" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7.2c.9-.1 1.7-.5 2.3-1.1-.3.9-.9 1.6-1.7 2.1.8 0 1.5-.3 2.1-.6-.5.8-1.1 1.5-1.8 2.1 0 5.9-4.2 10.8-11 10.8-2.2 0-4.2-.6-5.9-1.7.3 0 .7.1 1 .1 1.8 0 3.4-.6 4.7-1.6-1.7 0-3.1-1.1-3.5-2.7.2.1.5.1.8.1.4 0 .7 0 1-.1-1.8-.4-3.1-2-3.1-3.9v-.1c.5.3 1.1.5 1.8.5-1.1-.7-1.8-1.9-1.8-3.3 0-.7.2-1.4.6-2 2 2.5 5 4.1 8.4 4.3-.1-.3-.1-.6-.1-.9 0-2.2 1.8-4 4-4 1.1 0 2.1.5 2.8 1.2Z" fill="currentColor"/></svg></a>
                        <a href="#contact-form" aria-label="LinkedIn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8.2H4V20h3V8.2Zm.2-3.7A1.7 1.7 0 1 0 7.1 8a1.7 1.7 0 0 0 .1-3.4ZM20 13c0-3-1.6-5-4.4-5a3.8 3.8 0 0 0-3.4 1.9V8.2H9.3V20h2.9v-6.4c0-1.7 1-2.9 2.5-2.9 1.5 0 2.4 1.1 2.4 2.9V20H20Z" fill="currentColor"/></svg></a>
                    </div>
                </div>

                <div class="site-footer__column">
                    <h3>Quick Links</h3>
                    <ul>
                        @foreach ($footerLinks as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="site-footer__column">
                    <h3>Our Services</h3>
                    <ul>
                        @foreach ($serviceLinks as $service)
                            <li><a href="{{ $service['href'] }}">{{ $service['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="site-footer__column">
                    <h3>Contact Us</h3>
                    <ul class="site-footer__contact">
                        <li>AgroVision Smart Farming Project, Himachal Pradesh, India</li>
                        <li><a href="tel:+917018741392">+91 70187 41392</a></li>
                        <li><a href="mailto:hello@agrovision.com">hello@agrovision.com</a></li>
                        <li><a href="mailto:support@agrovision.com">support@agrovision.com</a></li>
                    </ul>
                </div>

                <div class="site-footer__column contact-footer-gallery">
                    <h3>Follow Us</h3>
                    <div class="contact-footer-gallery__grid">
                        @foreach (['thumbOne', 'thumbTwo', 'thumbThree', 'thumbFour', 'thumbFive', 'thumbSix'] as $thumb)
                            <img src="{{ $images[$thumb] }}" alt="AgroVision farming gallery image" loading="lazy">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="site-footer__bottom">
                <div class="site-container site-footer__bottom-inner">
                    <p>&copy; {{ now()->year }} {{ $brandName }}. All rights reserved.</p>
                    <div>
                        <a href="#contact-form">Privacy Policy</a>
                        <a href="#contact-form">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>

        @include('partials.chat-widget')

        <a class="site-backtotop" href="#top" data-backtotop aria-label="Back to top">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m7 14 5-5 5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <script src="{{ asset('js/home-page.js') }}" defer></script>
        <script src="{{ asset('js/chat-widget.js') }}" defer></script>
    </body>
</html>
