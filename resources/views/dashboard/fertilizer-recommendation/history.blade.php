@extends('dashboard_ui.layout')

@section('title', 'Fertilizer History')
@section('subtitle', 'Search, filter, view, and delete your fertilizer recommendation reports.')

@section('header_actions')
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.fertilizer') }}">Get Recommendation</a>
@endsection

@section('content')
    <section class="dash-card">
        <form class="dash-toolbar dash-toolbar--filters" method="GET" action="{{ route('dashboard.fertilizer.history') }}">
            <label><span>Search</span><input class="dash-input" name="search" value="{{ request('search') }}" placeholder="Crop or fertilizer"></label>
            <label><span>Soil Type</span><select class="dash-select" name="soil_type"><option value="">All</option>@foreach ($soilTypes as $soil)<option value="{{ $soil }}" @selected(request('soil_type') === $soil)>{{ $soil }}</option>@endforeach</select></label>
            <label><span>Confidence Min</span><input class="dash-input" type="number" name="confidence_min" value="{{ request('confidence_min') }}"></label>
            <label><span>From</span><input class="dash-input" type="date" name="date_from" value="{{ request('date_from') }}"></label>
            <label><span>To</span><input class="dash-input" type="date" name="date_to" value="{{ request('date_to') }}"></label>
            <button class="dash-button dash-button--primary" type="submit">Filter</button>
        </form>
        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead><tr><th>Crop</th><th>Soil Type</th><th>NPK Status</th><th>Problem</th><th>Recommended Fertilizer</th><th>Confidence</th><th>Location</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ $record->crop_name }}</td>
                            <td>{{ $record->soil_type }}</td>
                            <td>{{ $record->nitrogen_level ?: $record->nitrogen_value ?: 'N/A' }} / {{ $record->phosphorus_level ?: $record->phosphorus_value ?: 'N/A' }} / {{ $record->potassium_level ?: $record->potassium_value ?: 'N/A' }}</td>
                            <td>{{ $record->current_problem ?: 'N/A' }}</td>
                            <td>{{ $record->recommended_fertilizer_name ?: $record->recommended_fertilizer }}</td>
                            <td>{{ number_format((float) $record->confidence, 2) }}%</td>
                            <td>{{ $record->location ?: $record->location_name ?: 'N/A' }}</td>
                            <td>{{ $record->created_at?->format('M d, Y') }}</td>
                            <td>
                                <a class="dash-text-link" href="{{ route('dashboard.fertilizer.show', $record) }}">View</a>
                                <form method="POST" action="{{ route('dashboard.fertilizer.destroy', $record) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dash-text-link" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9">No fertilizer reports found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $records->links() }}
    </section>
@endsection
