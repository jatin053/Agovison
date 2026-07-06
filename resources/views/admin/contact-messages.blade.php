@extends('admin.layout')

@section('title', 'Contact Messages')
@section('subtitle', 'View messages submitted from the public contact form.')

@section('header_actions')
    <a class="admin-button admin-button--primary" href="{{ route('contact') }}">Open Contact Page</a>
@endsection

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--4">
            <article class="admin-card admin-card--metric admin-card--green"><p>Total Messages</p><h2>{{ $summary['total'] }}</h2><small>All contact submissions</small></article>
            <article class="admin-card admin-card--metric admin-card--blue"><p>Today</p><h2>{{ $summary['today'] }}</h2><small>New since midnight</small></article>
            <article class="admin-card admin-card--metric admin-card--purple"><p>Demo Requests</p><h2>{{ $summary['demo'] }}</h2><small>Book a Demo subjects</small></article>
            <article class="admin-card admin-card--metric admin-card--amber"><p>Support</p><h2>{{ $summary['support'] }}</h2><small>Support and technical help</small></article>
        </section>

        <section class="admin-card">
            <div class="admin-card__header">
                <div>
                    <p class="admin-card__eyebrow">Inbox</p>
                    <h2>Contact form details</h2>
                </div>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($messages as $message)
                            <tr>
                                <td>{{ $message->name }}</td>
                                <td>
                                    <strong>{{ $message->email }}</strong><br>
                                    <small>{{ $message->phone ?: 'No phone' }}</small>
                                </td>
                                <td><span class="admin-badge admin-badge--blue">{{ $message->subject }}</span></td>
                                <td>{{ \Illuminate\Support\Str::limit($message->message, 120) }}</td>
                                <td>{{ optional($message->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No contact messages submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
