@extends('dashboard_ui.layout')

@section('title', 'Soil History')
@section('subtitle', 'Filter, review, and reuse saved soil profiles.')

@section('header_actions')
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.soil.create') }}">Add Soil Profile</a>
@endsection

@section('content')
    <section class="dash-card">
        <form class="dash-toolbar dash-toolbar--filters" method="GET" action="{{ route('dashboard.soil.history') }}">
            <label><span>Soil Type</span><select class="dash-select" name="soil_type"><option value="">All</option>@foreach ($soilTypes as $soil)<option value="{{ $soil }}" @selected(request('soil_type') === $soil)>{{ $soil }}</option>@endforeach</select></label>
            <label><span>From</span><input class="dash-input" type="date" name="from" value="{{ request('from') }}"></label>
            <label><span>To</span><input class="dash-input" type="date" name="to" value="{{ request('to') }}"></label>
            <button class="dash-button dash-button--primary" type="submit">Filter</button>
        </form>

        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead><tr><th>Crop</th><th>Soil Type</th><th>Confidence</th><th>Source</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($profiles as $profile)
                        <tr>
                            <td>{{ $profile->crop_name ?: 'N/A' }}</td>
                            <td>{{ $profile->soil_type }}</td>
                            <td>{{ number_format((float) $profile->confidence, 2) }}%</td>
                            <td>{{ $profile->data_source }}</td>
                            <td>{{ $profile->created_at?->format('M d, Y') }}</td>
                            <td><a class="dash-text-link" href="{{ route('dashboard.soil.show', $profile) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No soil scans found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $profiles->links() }}
    </section>
@endsection
