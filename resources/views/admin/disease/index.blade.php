@extends('admin.layout')

@section('title', 'Disease Reports')
@section('subtitle', 'View, search, filter, export, and remove disease reports across all AgroVision users.')

@section('header_actions')
    <a class="admin-button admin-button--ghost" href="{{ route('admin.disease.csv', request()->query()) }}">Export CSV</a>
@endsection

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--4">
            <article class="admin-card admin-card--metric admin-card--green">
                <p class="admin-card__eyebrow">Total Reports</p>
                <h2>{{ $summary['total'] }}</h2>
                <p>All saved disease checks.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--blue">
                <p class="admin-card__eyebrow">High Confidence</p>
                <h2>{{ $summary['high'] }}</h2>
                <p>Confidence 85% and above.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--amber">
                <p class="admin-card__eyebrow">Possible Disease</p>
                <h2>{{ $summary['possible'] }}</h2>
                <p>Confidence 60% to 84.99%.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--purple">
                <p class="admin-card__eyebrow">Low Confidence</p>
                <h2>{{ $summary['low'] }}</h2>
                <p>Under 60% confidence.</p>
            </article>
        </section>

        <section class="admin-card">
            <form class="admin-grid admin-grid--3" method="GET" action="{{ route('admin.disease.index') }}">
                <label class="dash-field">
                    <span>Search by User / Crop / Disease / Location</span>
                    <input class="dash-input" name="search" value="{{ request('search') }}" placeholder="Search disease reports">
                </label>
                <label class="dash-field">
                    <span>Severity</span>
                    <select class="dash-select" name="severity">
                        <option value="">All</option>
                        @foreach (['High', 'Moderate', 'Low'] as $severity)
                            <option @selected(request('severity') === $severity)>{{ $severity }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="dash-field">
                    <span>Confidence Min</span>
                    <input class="dash-input" type="number" step="0.01" name="confidence_min" value="{{ request('confidence_min') }}">
                </label>
                <label class="dash-field">
                    <span>Confidence Max</span>
                    <input class="dash-input" type="number" step="0.01" name="confidence_max" value="{{ request('confidence_max') }}">
                </label>
                <label class="dash-field">
                    <span>Date From</span>
                    <input class="dash-input" type="date" name="date_from" value="{{ request('date_from') }}">
                </label>
                <label class="dash-field">
                    <span>Date To</span>
                    <input class="dash-input" type="date" name="date_to" value="{{ request('date_to') }}">
                </label>
                <button class="admin-button admin-button--primary" type="submit">Apply Filters</button>
                <a class="admin-button admin-button--ghost" href="{{ route('admin.disease.index') }}">Clear</a>
            </form>
        </section>

        <section class="admin-card">
            <div class="admin-card__header">
                <div>
                    <p class="admin-card__eyebrow">All Disease Reports</p>
                    <h2>Admin visibility across user scans</h2>
                </div>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Crop</th>
                            <th>Image</th>
                            <th>Disease</th>
                            <th>Confidence</th>
                            <th>Severity</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            @php
                                $imageUrl = $record->image_path
                                    ? asset('storage/'.$record->image_path)
                                    : ($record->leaf_image_path ? asset('storage/'.$record->leaf_image_path) : null);
                            @endphp
                            <tr>
                                <td>{{ $record->id }}</td>
                                <td>{{ $record->user?->name ?? 'Deleted user' }}</td>
                                <td>{{ $record->user?->email ?? 'N/A' }}</td>
                                <td>{{ $record->crop_name }}</td>
                                <td>@if ($imageUrl)<img src="{{ $imageUrl }}" alt="{{ $record->crop_name }}" style="width:56px;height:56px;object-fit:cover;border-radius:14px;">@endif</td>
                                <td>{{ $record->disease_name }}</td>
                                <td>{{ number_format((float) $record->confidence, 2) }}%</td>
                                <td>{{ $record->severity }}</td>
                                <td>{{ $record->location }}</td>
                                <td>{{ $record->created_at?->format('M d, Y') }}</td>
                                <td>
                                    <div class="admin-button-row">
                                        <a class="admin-button admin-button--ghost" href="{{ route('admin.disease.show', $record) }}">View</a>
                                        <form method="POST" action="{{ route('admin.disease.destroy', $record) }}" onsubmit="return confirm('Delete this disease report?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="admin-button admin-button--dark" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">No disease reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="dash-button-row">
                {{ $records->links('vendor.pagination.admin') }}
            </div>
        </section>
    </div>
@endsection
