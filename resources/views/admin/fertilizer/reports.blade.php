@extends('admin.layout')

@section('title', 'Fertilizer Recommendation Reports')
@section('subtitle', 'View every user recommendation, filter, review, delete, and export CSV.')

@section('header_actions')
    <a class="admin-button admin-button--primary" href="{{ route('admin.fertilizer.reports.csv', request()->query()) }}">Export CSV</a>
@endsection

@section('content')
    <section class="admin-card">
        <form class="admin-filters" method="GET" action="{{ route('admin.fertilizer.reports') }}">
            <input class="admin-input" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="User, crop, fertilizer, location">
            <input class="admin-input" name="soil_type" value="{{ $filters['soil_type'] ?? '' }}" placeholder="Soil type">
            <input class="admin-input" type="number" name="confidence_min" value="{{ $filters['confidence_min'] ?? '' }}" placeholder="Min confidence">
            <select class="admin-input" name="reviewed"><option value="">All review</option><option value="1" @selected(($filters['reviewed'] ?? '') === '1')>Reviewed</option><option value="0" @selected(($filters['reviewed'] ?? '') === '0')>Pending</option></select>
            <input class="admin-input" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
            <input class="admin-input" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
            <button class="admin-button admin-button--primary" type="submit">Filter</button>
        </form>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>ID</th><th>User</th><th>Email</th><th>Crop</th><th>Soil Type</th><th>NPK</th><th>Problem</th><th>Recommended Fertilizer</th><th>Confidence</th><th>Location</th><th>Reviewed</th><th>Date</th><th>Action</th></tr></thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $record->id }}</td><td>{{ $record->user?->name ?? 'Deleted user' }}</td><td>{{ $record->user?->email ?? 'N/A' }}</td><td>{{ $record->crop_name }}</td><td>{{ $record->soil_type }}</td>
                            <td>{{ $record->nitrogen_level ?: $record->nitrogen_value }}/{{ $record->phosphorus_level ?: $record->phosphorus_value }}/{{ $record->potassium_level ?: $record->potassium_value }}</td>
                            <td>{{ $record->current_problem ?: 'N/A' }}</td><td>{{ $record->recommended_fertilizer_name ?: $record->recommended_fertilizer }}</td><td>{{ $record->confidence }}%</td><td>{{ $record->location ?: $record->location_name }}</td>
                            <td>{{ $record->admin_reviewed ? 'Yes' : 'No' }}</td><td>{{ $record->created_at?->format('M d, Y') }}</td><td><a class="admin-button admin-button--ghost" href="{{ route('admin.fertilizer.reports.show', $record) }}">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $records->links('vendor.pagination.admin') }}
    </section>
@endsection
