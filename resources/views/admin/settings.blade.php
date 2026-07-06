@extends('admin.layout')

@section('title', 'Admin Settings')
@section('subtitle', 'Review key application configuration, environment details, and deployment reminders.')

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--2-1">
            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">System Configuration</p>
                        <h2>Current runtime values</h2>
                    </div>
                </div>
                <div class="admin-config-list">
                    @foreach ($system as $label => $value)
                        <div class="admin-config-list__item">
                            <span>{{ $label }}</span>
                            <strong>{{ $value ?: 'Not set' }}</strong>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">Deployment Notes</p>
                        <h2>Setup checklist</h2>
                    </div>
                </div>
                <ul class="admin-check-list">
                    <li>Create the MySQL database named `agro` if it does not exist.</li>
                    <li>Run `php artisan migrate --seed` after the database is ready.</li>
                    <li>Log in using `admin@agrovision.com` to confirm admin access.</li>
                </ul>
            </article>
        </section>
    </div>
@endsection
