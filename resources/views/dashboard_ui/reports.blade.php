@extends('dashboard_ui.layout')

@section('title', 'Farm Reports')
@section('subtitle', 'Review your saved AgroVision records from MySQL only. No external API is called on this page.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.reports.csv', request()->query()) }}">Export CSV</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.reports.pdf', request()->query()) }}">Download PDF</a>
@endsection

@section('content')
    <div class="dash-content-stack">
        <section class="dash-card">
            <form class="dash-toolbar dash-toolbar--filters" method="GET" action="{{ route('dashboard.reports') }}">
                <label class="dash-field">
                    <span>Feature Type</span>
                    <select class="dash-select" name="type">
                        <option value="">All</option>
                        @foreach ($featureTypes as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['type'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="dash-field">
                    <span>Crop</span>
                    <input class="dash-input" name="crop" value="{{ $filters['crop'] ?? '' }}">
                </label>
                <label class="dash-field">
                    <span>Location</span>
                    <input class="dash-input" name="location" value="{{ $filters['location'] ?? '' }}">
                </label>
                <label class="dash-field">
                    <span>From</span>
                    <input class="dash-input" type="date" name="from" value="{{ $filters['from'] ?? '' }}">
                </label>
                <label class="dash-field">
                    <span>To</span>
                    <input class="dash-input" type="date" name="to" value="{{ $filters['to'] ?? '' }}">
                </label>
                <button class="dash-button dash-button--primary" type="submit">Apply Filters</button>
            </form>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">All Reports</p>
                    <h2>{{ $reports->count() }} saved records</h2>
                </div>
            </div>

            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Crop</th>
                            <th>Location</th>
                            <th>Result</th>
                            <th>Details</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td><span class="dash-badge dash-badge--green">{{ $report['type_label'] }}</span></td>
                                <td>{{ $report['crop'] }}</td>
                                <td>{{ $report['location'] }}</td>
                                <td>{{ $report['summary'] }}</td>
                                <td>{{ $report['details'] }}</td>
                                <td>{{ $report['date'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
