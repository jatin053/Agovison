@extends('admin.layout')

@section('title', 'Soil Report Details')
@section('subtitle', 'Review complete soil information and mark reports as admin reviewed.')

@section('header_actions')
    <a class="admin-button admin-button--ghost" href="{{ route('admin.soil.index') }}">Back</a>
@endsection

@section('content')
    <section class="admin-card">
        <div class="admin-card__header">
            <div><p>Soil Report #{{ $profile->id }}</p><h2>{{ $profile->soil_type }} profile</h2></div>
            <span class="admin-badge {{ $profile->is_verified ? 'admin-badge--green' : 'admin-badge--orange' }}">{{ $profile->is_verified ? 'Verified' : 'Pending Review' }}</span>
        </div>
        <div class="admin-config-list">
            <div class="admin-config-list__item"><span>User</span><strong>{{ $profile->user?->name ?? 'Deleted user' }}</strong></div>
            <div class="admin-config-list__item"><span>Email</span><strong>{{ $profile->user?->email ?? 'N/A' }}</strong></div>
            <div class="admin-config-list__item"><span>Location</span><strong>{{ $profile->location ?: 'N/A' }}</strong></div>
            <div class="admin-config-list__item"><span>pH</span><strong>{{ $profile->ph_value ?: 'N/A' }}</strong></div>
            <div class="admin-config-list__item"><span>N / P / K</span><strong>{{ $profile->nitrogen_level ?: 'N/A' }} / {{ $profile->phosphorus_level ?: 'N/A' }} / {{ $profile->potassium_level ?: 'N/A' }}</strong></div>
            <div class="admin-config-list__item"><span>Sand / Clay / Silt</span><strong>{{ $profile->sand_percentage ?: 'N/A' }} / {{ $profile->clay_percentage ?: 'N/A' }} / {{ $profile->silt_percentage ?: 'N/A' }}</strong></div>
            <div class="admin-config-list__item"><span>Source</span><strong>{{ $profile->data_source }}</strong></div>
            <div class="admin-config-list__item"><span>Notes</span><strong>{{ $profile->notes ?: 'No notes' }}</strong></div>
        </div>
    </section>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.soil.update', $profile) }}">
            @csrf
            @method('PATCH')
            <label class="admin-field"><span>Admin Note</span><textarea class="admin-input" name="admin_note">{{ old('admin_note', $profile->admin_note) }}</textarea></label>
            <label class="admin-check"><input type="checkbox" name="is_verified" value="1" @checked($profile->is_verified)> Mark as reviewed</label>
            <button class="admin-button admin-button--primary" type="submit">Save Review</button>
        </form>
        <form method="POST" action="{{ route('admin.soil.destroy', $profile) }}" style="margin-top:14px;">
            @csrf
            @method('DELETE')
            <button class="admin-button admin-button--danger" type="submit">Delete Invalid Record</button>
        </form>
    </section>
@endsection
