@extends('admin.layout')

@section('title', 'Farm Reports')
@section('subtitle', 'Search and filter saved activity across every AgroVision user and smart farming module.')

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--4">
            <article class="admin-card admin-card--metric admin-card--green">
                <p class="admin-card__eyebrow">Filtered Records</p>
                <h2>{{ $summary['total'] }}</h2>
                <p>Matching the current admin filters.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--blue">
                <p class="admin-card__eyebrow">Crop + Yield</p>
                <h2>{{ $summary['crop'] + $summary['yield'] }}</h2>
                <p>Planning and production records.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--purple">
                <p class="admin-card__eyebrow">Disease + Fertilizer</p>
                <h2>{{ $summary['disease'] + $summary['fertilizer'] }}</h2>
                <p>Plant health and nutrient records.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--amber">
                <p class="admin-card__eyebrow">Weather Searches</p>
                <h2>{{ $summary['weather'] }}</h2>
                <p>Google Weather backed searches.</p>
            </article>
        </section>

        <section class="admin-card">
            <form class="admin-grid admin-grid--3" method="GET" action="{{ route('admin.reports') }}">
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
                    <span>User Name / Email</span>
                    <input class="dash-input" name="user" value="{{ $filters['user'] ?? '' }}">
                </label>
                <label class="dash-field">
                    <span>Search Crop / Location / Result</span>
                    <input class="dash-input" name="search" value="{{ $filters['search'] ?? '' }}">
                </label>
                <button class="admin-button admin-button--primary" type="submit">Filter Activity</button>
                <a class="admin-button admin-button--ghost" href="{{ route('admin.reports') }}">Clear</a>
            </form>
        </section>

        <section class="admin-card">
            <div class="admin-card__header">
                <div>
                    <p class="admin-card__eyebrow">All User Activity</p>
                    <h2>Function-wise records</h2>
                </div>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Feature</th>
                            <th>User Input</th>
                            <th>Result</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>
                                    <strong>{{ $record['user'] }}</strong>
                                    <p>{{ $record['email'] }}</p>
                                </td>
                                <td><span class="admin-badge admin-badge--green">{{ $record['type_label'] }}</span></td>
                                <td>
                                    <strong>{{ $record['crop'] }}</strong>
                                    <p>{{ $record['location'] }}</p>
                                    @foreach (array_slice(array_filter($record['input']), 0, 3, true) as $label => $value)
                                        <p><strong>{{ $label }}:</strong> {{ $value }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    <strong>{{ $record['summary'] }}</strong>
                                    @foreach (array_slice(array_filter($record['result']), 0, 3, true) as $label => $value)
                                        <p><strong>{{ $label }}:</strong> {{ $value }}</p>
                                    @endforeach
                                </td>
                                <td>{{ $record['date'] }}</td>
                                <td><a class="admin-button admin-button--ghost" href="{{ route('admin.reports.show', [$record['type'], $record['id']]) }}">View Details</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No farm activity records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
