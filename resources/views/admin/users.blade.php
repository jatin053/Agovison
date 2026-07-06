@extends('admin.layout')

@section('title', 'Admin Users')
@section('subtitle', 'Review registered users, admin access, and verification status.')

@section('header_actions')
    <a class="admin-button admin-button--primary" href="{{ route('admin.dashboard') }}">Overview</a>
@endsection

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--4">
            <article class="admin-card admin-card--metric admin-card--green"><p>Total Users</p><h2>{{ $summary['total'] }}</h2><small>All registered accounts</small></article>
            <article class="admin-card admin-card--metric admin-card--purple"><p>Admins</p><h2>{{ $summary['admins'] }}</h2><small>Panel-enabled accounts</small></article>
            <article class="admin-card admin-card--metric admin-card--blue"><p>Verified</p><h2>{{ $summary['verified'] }}</h2><small>Email verified users</small></article>
            <article class="admin-card admin-card--metric admin-card--amber"><p>Pending</p><h2>{{ $summary['pending'] }}</h2><small>Still unverified</small></article>
        </section>

        <section class="admin-card">
            <div class="admin-card__header">
                <div>
                    <p class="admin-card__eyebrow">User Directory</p>
                    <h2>All registered accounts</h2>
                </div>
            </div>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Verified</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="admin-badge {{ $user->is_admin ? 'admin-badge--purple' : 'admin-badge--green' }}">
                                        {{ $user->is_admin ? 'Admin' : 'Farmer' }}
                                    </span>
                                </td>
                                <td>{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</td>
                                <td>{{ optional($user->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
