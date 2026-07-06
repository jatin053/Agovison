@extends('admin.layout')

@section('title', 'Soil Reports')
@section('subtitle', 'View, filter, verify, export, and manage soil profiles across AgroVision users.')

@section('header_actions')
    <a class="admin-button admin-button--primary" href="{{ route('admin.soil.csv', request()->query()) }}">Export CSV</a>
@endsection

@section('content')
    <div class="admin-grid admin-grid--4">
        <article class="admin-card admin-card--metric"><p>Total Soil Profiles</p><h2>{{ $summary['total'] }}</h2><small>All saved profiles</small></article>
        <article class="admin-card admin-card--metric admin-card--green"><p>Manual</p><h2>{{ $summary['manual'] }}</h2><small>Manually entered profiles</small></article>
        <article class="admin-card admin-card--metric admin-card--blue"><p>Estimated</p><h2>{{ $summary['estimated'] }}</h2><small>Location-based profiles</small></article>
        <article class="admin-card admin-card--metric admin-card--purple"><p>Verified</p><h2>{{ $summary['verified'] }}</h2><small>Reviewed reports</small></article>
    </div>

    <section class="admin-card">
        <form class="admin-filters" method="GET" action="{{ route('admin.soil.index') }}">
            <label><span>Search</span><input class="admin-input" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="User, email, location, soil type"></label>
            <label><span>pH Min</span><input class="admin-input" type="number" step="0.01" name="ph_min" value="{{ $filters['ph_min'] ?? '' }}"></label>
            <label><span>pH Max</span><input class="admin-input" type="number" step="0.01" name="ph_max" value="{{ $filters['ph_max'] ?? '' }}"></label>
            <label><span>Source</span><input class="admin-input" name="data_source" value="{{ $filters['data_source'] ?? '' }}" placeholder="Manual Entry"></label>
            <label><span>Verified</span><select class="admin-input" name="verified"><option value="">All</option><option value="1" @selected(($filters['verified'] ?? '') === '1')>Yes</option><option value="0" @selected(($filters['verified'] ?? '') === '0')>No</option></select></label>
            <button class="admin-button admin-button--primary" type="submit">Filter</button>
        </form>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>ID</th><th>User Name</th><th>Email</th><th>Location</th><th>Soil Type</th><th>pH</th><th>N</th><th>P</th><th>K</th><th>Data Source</th><th>Verified</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse ($profiles as $profile)
                        <tr>
                            <td>{{ $profile->id }}</td>
                            <td>{{ $profile->user?->name ?? 'Deleted user' }}</td>
                            <td>{{ $profile->user?->email ?? 'N/A' }}</td>
                            <td>{{ $profile->location ?: 'N/A' }}</td>
                            <td>{{ $profile->soil_type }}</td>
                            <td>{{ $profile->ph_value ?: 'N/A' }}</td>
                            <td>{{ $profile->nitrogen_level ?: 'N/A' }}</td>
                            <td>{{ $profile->phosphorus_level ?: 'N/A' }}</td>
                            <td>{{ $profile->potassium_level ?: 'N/A' }}</td>
                            <td>{{ $profile->data_source }}</td>
                            <td><span class="admin-badge {{ $profile->is_verified ? 'admin-badge--green' : 'admin-badge--orange' }}">{{ $profile->is_verified ? 'Yes' : 'No' }}</span></td>
                            <td>{{ $profile->created_at?->format('M d, Y') }}</td>
                            <td><a class="admin-button admin-button--ghost" href="{{ route('admin.soil.show', $profile) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="13">No soil reports found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $profiles->links('vendor.pagination.admin') }}
    </section>

    <section class="admin-card">
        <div class="admin-card__header"><div><p>Recent Soil Entries</p><h2>Latest saved profiles</h2></div></div>
        <div class="admin-config-list">
            @foreach ($summary['recent'] as $recent)
                <div class="admin-config-list__item"><span>{{ $recent->soil_type }} | {{ $recent->location ?: 'No location' }}</span><strong>{{ $recent->created_at?->format('M d, Y') }}</strong></div>
            @endforeach
        </div>
    </section>
@endsection
