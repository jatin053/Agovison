@extends('dashboard_ui.layout')

@section('title', 'Disease History')
@section('subtitle', 'Search, filter, and manage your own crop disease reports.')

@section('header_actions')
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.disease') }}">Detect Disease</a>
@endsection

@section('content')
    <div class="dash-content-stack">
        @if (session('status'))
            <div class="dash-highlight">
                <strong>Update</strong>
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <section class="dash-card">
            <form class="dash-toolbar dash-toolbar--filters" method="GET" action="{{ route('dashboard.disease.history') }}">
                <label class="dash-field">
                    <span>Search by Crop or Disease</span>
                    <input class="dash-input" name="search" value="{{ request('search') }}" placeholder="Tomato, early blight...">
                </label>
                <label class="dash-field">
                    <span>Date From</span>
                    <input class="dash-input" type="date" name="date_from" value="{{ request('date_from') }}">
                </label>
                <label class="dash-field">
                    <span>Date To</span>
                    <input class="dash-input" type="date" name="date_to" value="{{ request('date_to') }}">
                </label>
                <button class="dash-button dash-button--primary" type="submit">Filter</button>
            </form>
        </section>

        <section class="dash-card">
            <div class="dash-card__header">
                <div>
                    <p class="dash-eyebrow">Reports</p>
                    <h2>Your disease detection history</h2>
                </div>
            </div>

            <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Crop</th>
                            <th>Detected Disease</th>
                            <th>Confidence</th>
                            <th>Severity</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Actions</th>
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
                                <td>
                                    @if ($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $record->crop_name }}" style="width:56px;height:56px;object-fit:cover;border-radius:14px;">
                                    @endif
                                </td>
                                <td>{{ $record->crop_name }}</td>
                                <td>{{ $record->disease_name }}</td>
                                <td>{{ number_format((float) $record->confidence, 2) }}%</td>
                                <td>{{ $record->severity }}</td>
                                <td>{{ $record->location }}</td>
                                <td>{{ $record->created_at?->format('M d, Y') }}</td>
                                <td>
                                    <div class="dash-button-row">
                                        <a class="dash-button dash-button--ghost" href="{{ route('dashboard.disease.show', $record) }}">View</a>
                                        <form method="POST" action="{{ route('dashboard.disease.destroy', $record) }}" onsubmit="return confirm('Delete this disease report?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dash-button dash-button--ghost" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No disease reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="dash-button-row">
                {{ $records->links() }}
            </div>
        </section>
    </div>
@endsection
