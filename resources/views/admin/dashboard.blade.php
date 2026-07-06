@extends('admin.layout')

@section('title', 'Admin Overview')
@section('subtitle', 'See user growth, access control, and system readiness from one clean admin workspace.')

@section('header_actions')
    <a class="admin-button admin-button--ghost" href="{{ route('admin.users') }}">Manage Users</a>
    <a class="admin-button admin-button--primary" href="{{ route('admin.reports') }}">Open Reports</a>
@endsection

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--4">
            @foreach ($stats as $stat)
                <article class="admin-card admin-card--metric admin-card--{{ $stat['tone'] }}">
                    <p>{{ $stat['label'] }}</p>
                    <h2>{{ $stat['value'] }}</h2>
                    <small>{{ $stat['detail'] }}</small>
                </article>
            @endforeach
        </section>

        <section class="admin-grid admin-grid--2-1">
            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">Recent Accounts</p>
                        <h2>Latest user registrations</h2>
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
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="admin-badge {{ $user->is_admin ? 'admin-badge--purple' : 'admin-badge--green' }}">
                                            {{ $user->is_admin ? 'Admin' : 'Farmer' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->email_verified_at ? 'Yes' : 'Pending' }}</td>
                                    <td>{{ optional($user->created_at)->format('M d, Y h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">System Audit</p>
                        <h2>Readiness checklist</h2>
                    </div>
                </div>

                <div class="admin-list">
                    @foreach ($auditItems as $item)
                        <div class="admin-list__item">
                            <div>
                                <strong>{{ $item['title'] }}</strong>
                                <p>{{ $item['copy'] }}</p>
                            </div>
                            <span class="admin-badge admin-badge--blue">{{ $item['status'] }}</span>
                        </div>
                    @endforeach
                </div>
            </article>
        </section>

        <section class="admin-grid admin-grid--3">
            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">Security Notes</p>
                        <h2>Admin access flow</h2>
                    </div>
                </div>
                <ul class="admin-check-list">
                    <li>Only users with `is_admin = 1` can reach `/admin` routes.</li>
                    <li>Non-admin users are redirected back to the farmer dashboard.</li>
                    <li>Default seeded admin account is ready after migration and seeding.</li>
                </ul>
            </article>

            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">Database</p>
                        <h2>MySQL setup</h2>
                    </div>
                </div>
                <p>This panel is configured for the MySQL database named <strong>`agro`</strong>. Use the included SQL helper or the migration command to initialize the schema.</p>
            </article>

            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">Next Actions</p>
                        <h2>What to do next</h2>
                    </div>
                </div>
                <ul class="admin-check-list">
                    <li>Run migrations and seeders once MySQL is available.</li>
                    <li>Log in with the seeded admin account to review access.</li>
                    <li>Customize user/report workflows as your data model grows.</li>
                </ul>
            </article>
        </section>
    </div>
@endsection
