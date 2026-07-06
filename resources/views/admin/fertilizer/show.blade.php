@extends('admin.layout')

@section('title', 'Fertilizer Report Details')
@section('subtitle', 'Review recommendation detail and add admin note.')

@section('content')
    <section class="admin-card">
        <div class="admin-config-list">
            <div class="admin-config-list__item"><span>User</span><strong>{{ $record->user?->name ?? 'Deleted user' }}</strong></div>
            <div class="admin-config-list__item"><span>Crop</span><strong>{{ $record->crop_name }}</strong></div>
            <div class="admin-config-list__item"><span>Recommended</span><strong>{{ $record->recommended_fertilizer_name ?: $record->recommended_fertilizer }}</strong></div>
            <div class="admin-config-list__item"><span>Confidence</span><strong>{{ $record->confidence }}%</strong></div>
            <div class="admin-config-list__item"><span>Status</span><strong>{{ $record->status }}</strong></div>
            <div class="admin-config-list__item"><span>Warnings</span><strong>{{ implode(', ', $record->warnings ?? []) }}</strong></div>
        </div>
    </section>
    <section class="admin-card">
        <form method="POST" action="{{ route('admin.fertilizer.reports.review', $record) }}">
            @csrf
            @method('PATCH')
            <label class="admin-field"><span>Admin Note</span><textarea class="admin-input" name="admin_note">{{ old('admin_note', $record->admin_note) }}</textarea></label>
            <label class="admin-check"><input type="checkbox" name="admin_reviewed" value="1" @checked($record->admin_reviewed)> Mark reviewed</label>
            <button class="admin-button admin-button--primary" type="submit">Save Review</button>
        </form>
    </section>
@endsection
