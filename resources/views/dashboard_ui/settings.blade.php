@extends('dashboard_ui.layout')

@section('title', 'Settings')
@section('subtitle', 'Adjust account security, alerts, display preferences, and workflow defaults with the same exact interface language.')

@section('content')
    <div class="dash-content-stack">
        <section class="dash-grid dash-grid--3">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Account Security</p><h2>Protect your account</h2></div>
                </div>
                <div class="dash-list">
                    <div class="dash-list__item"><div><strong>Password</strong><p>Last changed 3 months ago.</p></div><button class="dash-button dash-button--ghost" type="button">Change</button></div>
                    <div class="dash-list__item"><div><strong>Two-step verification</strong><p>Add an extra layer of security.</p></div><label class="dash-switch"><input type="checkbox" checked><span></span></label></div>
                    <div class="dash-list__item"><div><strong>Login alerts</strong><p>Receive an email when a new device signs in.</p></div><label class="dash-switch"><input type="checkbox" checked><span></span></label></div>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Notifications</p><h2>Choose what you get</h2></div>
                </div>
                <div class="dash-list">
                    <div class="dash-list__item"><div><strong>Weather Alerts</strong><p>Receive alerts for severe weather updates.</p></div><label class="dash-switch"><input type="checkbox" checked><span></span></label></div>
                    <div class="dash-list__item"><div><strong>Disease Alerts</strong><p>Get notified about crop disease risks.</p></div><label class="dash-switch"><input type="checkbox" checked><span></span></label></div>
                    <div class="dash-list__item"><div><strong>Monthly Reports</strong><p>Receive summary exports each month.</p></div><label class="dash-switch"><input type="checkbox"><span></span></label></div>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Language & Theme</p><h2>Workspace preferences</h2></div>
                </div>
                <div class="dash-field-grid dash-field-grid--tight">
                    <label class="dash-field dash-field--full">
                        <span>Language</span>
                        <select class="dash-select">
                            <option selected>English</option>
                            <option>Hindi</option>
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Date Format</span>
                        <select class="dash-select">
                            <option selected>DD MMM YYYY</option>
                            <option>MM/DD/YYYY</option>
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Time Format</span>
                        <select class="dash-select">
                            <option selected>12-Hour (AM/PM)</option>
                            <option>24-Hour</option>
                        </select>
                    </label>
                    <label class="dash-field dash-field--full">
                        <span>Theme</span>
                        <select class="dash-select">
                            <option selected>Light</option>
                            <option>System</option>
                        </select>
                    </label>
                </div>
            </article>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div><p class="dash-eyebrow">Workflow Defaults</p><h2>Operational preferences</h2></div>
            </div>
            <div class="dash-grid dash-grid--3">
                <article class="dash-card dash-card--nested">
                    <h3>Prediction Defaults</h3>
                    <p>Save preferred crop, area unit, and irrigation settings for quicker yield predictions.</p>
                </article>
                <article class="dash-card dash-card--nested">
                    <h3>Report Delivery</h3>
                    <p>Choose who receives weekly and monthly exports automatically.</p>
                </article>
                <article class="dash-card dash-card--nested">
                    <h3>Alert Sensitivity</h3>
                    <p>Control how aggressive weather and disease notifications should be.</p>
                </article>
            </div>
        </section>
    </div>
@endsection
