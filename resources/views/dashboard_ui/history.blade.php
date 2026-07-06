@extends('dashboard_ui.layout')

@section('title', 'My History')
@section('subtitle', 'Track your past analyses, downloads, and actions with one clean, consistent layout.')

@section('content')
    <div class="dash-content-stack">
        <section class="dash-card">
            <div class="dash-toolbar dash-toolbar--filters">
                <label class="dash-field">
                    <span>Date Range</span>
                    <input class="dash-input" type="text" value="May 1, 2024 - May 29, 2024">
                </label>
                <label class="dash-field">
                    <span>Feature Type</span>
                    <select class="dash-select">
                        <option selected>All Features</option>
                        <option>Crop Recommendation</option>
                        <option>Yield Prediction</option>
                    </select>
                </label>
                <label class="dash-field">
                    <span>Status</span>
                    <select class="dash-select">
                        <option selected>All Statuses</option>
                        <option>Completed</option>
                        <option>Needs Attention</option>
                    </select>
                </label>
                <label class="dash-field dash-field--grow">
                    <span>Search</span>
                    <input class="dash-input" type="text" value="Search by keywords...">
                </label>
            </div>
        </section>

        <section class="dash-grid dash-grid--4">
            <article class="dash-card dash-card--metric dash-tone-green"><div class="dash-metric"><div><p>Total Activities</p><h2>128</h2><small>+18% vs last month</small></div></div></article>
            <article class="dash-card dash-card--metric dash-tone-blue"><div class="dash-metric"><div><p>Completed Analyses</p><h2>96</h2><small>+20% vs last month</small></div></div></article>
            <article class="dash-card dash-card--metric dash-tone-amber"><div class="dash-metric"><div><p>Alerts Generated</p><h2>18</h2><small>+12% vs last month</small></div></div></article>
            <article class="dash-card dash-card--metric dash-tone-purple"><div class="dash-metric"><div><p>Exported Reports</p><h2>34</h2><small>+15% vs last month</small></div></div></article>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Activity History</p>
                    <h2>Recent timeline</h2>
                </div>
            </div>
            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Details</th>
                            <th>Location</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Crop Recommendation</td><td>Suggested Maize for soil pH 6.5</td><td>Patna, Bihar</td><td>Today, 10:30 AM</td><td><span class="dash-badge dash-badge--green">Completed</span></td><td>View</td></tr>
                        <tr><td>Yield Prediction</td><td>Wheat | Expected 42 q/acre</td><td>Patna, Bihar</td><td>Today, 09:15 AM</td><td><span class="dash-badge dash-badge--green">Completed</span></td><td>View</td></tr>
                        <tr><td>Disease Detection</td><td>Leaf blight | Confidence 82%</td><td>Muzaffarpur, Bihar</td><td>Yesterday, 04:20 PM</td><td><span class="dash-badge dash-badge--orange">Needs Attention</span></td><td>View</td></tr>
                        <tr><td>Fertilizer Recommendation</td><td>Urea, DAP, Potash blend</td><td>Gaya, Bihar</td><td>Yesterday, 11:45 AM</td><td><span class="dash-badge dash-badge--green">Completed</span></td><td>View</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="dash-grid dash-grid--2-1">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Monthly Trend</p>
                        <h2>Activity growth</h2>
                    </div>
                </div>
                <div class="dash-bars">
                    <span style="height: 32%"></span>
                    <span style="height: 48%"></span>
                    <span style="height: 51%"></span>
                    <span style="height: 68%"></span>
                    <span style="height: 72%"></span>
                    <span style="height: 88%"></span>
                </div>
                <div class="dash-bars__labels"><span>Dec</span><span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span></div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Export</p>
                        <h2>Report actions</h2>
                    </div>
                </div>
                <p>Download your data or view detailed insights in polished formats.</p>
                <div class="dash-button-column">
                    <a class="dash-button dash-button--primary" href="{{ route('dashboard.reports') }}">Download PDF</a>
                    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.reports') }}">Export CSV</a>
                    <a class="dash-button dash-button--link" href="{{ route('dashboard.reports') }}">View Detailed Report</a>
                </div>
            </article>
        </section>
    </div>
@endsection
