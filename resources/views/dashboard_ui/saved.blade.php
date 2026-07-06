@extends('dashboard_ui.layout')

@section('title', 'Saved Results')
@section('subtitle', 'Keep important analyses, comparisons, and reusable recommendations organized in one matching interface.')

@section('header_actions')
    <button class="dash-button dash-button--ghost" type="button">Create Collection</button>
@endsection

@section('content')
    <div class="dash-content-stack">
        <section class="dash-card">
            <div class="dash-toolbar dash-toolbar--filters">
                <label class="dash-field dash-field--grow">
                    <span>Search Saved Results</span>
                    <input class="dash-input" type="text" value="Search by crop, field, or recommendation...">
                </label>
                <label class="dash-field">
                    <span>Category</span>
                    <select class="dash-select">
                        <option selected>All Categories</option>
                        <option>Crop Recommendation</option>
                        <option>Disease Detection</option>
                    </select>
                </label>
                <label class="dash-field">
                    <span>Sort By</span>
                    <select class="dash-select">
                        <option selected>Most Recent</option>
                        <option>Highest Confidence</option>
                    </select>
                </label>
            </div>
        </section>

        <section class="dash-grid dash-grid--3">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Pinned Result</p><h2>Paddy crop match</h2></div>
                    <span class="dash-badge dash-badge--green">92% Confidence</span>
                </div>
                <p>Saved from the south block recommendation set for quick reference before planting.</p>
                <div class="dash-button-row">
                    <a class="dash-button dash-button--primary" href="{{ route('dashboard.crop') }}">Open</a>
                    <button class="dash-button dash-button--ghost" type="button">Share</button>
                </div>
            </article>
            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Collection</p><h2>Disease Follow-ups</h2></div>
                </div>
                <p>4 saved scans with treatment progress and severity comparisons.</p>
                <div class="dash-button-row">
                    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.disease') }}">View Collection</a>
                </div>
            </article>
            <article class="dash-card">
                <div class="dash-card__header">
                    <div><p class="dash-eyebrow">Collection</p><h2>Yield Benchmarks</h2></div>
                </div>
                <p>Saved predictions used to compare acreage performance over time.</p>
                <div class="dash-button-row">
                    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.yield') }}">Open Benchmarks</a>
                </div>
            </article>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div><p class="dash-eyebrow">Saved Library</p><h2>Recent saved items</h2></div>
            </div>
            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Feature</th>
                            <th>Saved On</th>
                            <th>Confidence</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Paddy recommendation - South Block</td><td>Crop Recommendation</td><td>Jun 09, 2026</td><td>92%</td><td>Shortlisted for Kharif season.</td></tr>
                        <tr><td>Tomato disease scan #14</td><td>Disease Detection</td><td>Jun 08, 2026</td><td>87%</td><td>Monitor after treatment round one.</td></tr>
                        <tr><td>Wheat yield estimate</td><td>Yield Prediction</td><td>Jun 07, 2026</td><td>Excellent</td><td>Used for procurement planning.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
