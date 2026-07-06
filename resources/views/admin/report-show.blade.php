@extends('admin.layout')

@section('title', $record['type_label'].' Report')
@section('subtitle', 'Complete admin view of the user input and the result returned by AgroVision.')

@section('header_actions')
    <a class="admin-button admin-button--ghost" href="{{ route('admin.reports') }}">Back to Reports</a>
@endsection

@php
    $cleanInput = array_filter($record['input'], fn ($value) => filled($value));
    $cleanResult = array_filter($record['result'], fn ($value) => filled($value));
@endphp

@section('content')
    <div class="admin-stack">
        <section class="admin-grid admin-grid--4">
            <article class="admin-card admin-card--metric admin-card--green">
                <p class="admin-card__eyebrow">User</p>
                <h2>{{ $record['user'] }}</h2>
                <p>{{ $record['email'] }}</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--blue">
                <p class="admin-card__eyebrow">Feature</p>
                <h2>{{ $record['type_label'] }}</h2>
                <p>Module report type.</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--purple">
                <p class="admin-card__eyebrow">Crop / Item</p>
                <h2>{{ $record['crop'] }}</h2>
                <p>{{ $record['location'] }}</p>
            </article>
            <article class="admin-card admin-card--metric admin-card--amber">
                <p class="admin-card__eyebrow">Created</p>
                <h2>{{ $record['date'] }}</h2>
                <p>Saved in AgroVision database.</p>
            </article>
        </section>

        <section class="admin-grid admin-grid--2">
            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">User Input</p>
                        <h2>Data entered by the user</h2>
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <tbody>
                            @forelse ($cleanInput as $label => $value)
                                <tr>
                                    <th>{{ $label }}</th>
                                    <td>{{ $value }}</td>
                                </tr>
                            @empty
                                <tr><td>No user input details available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="admin-card">
                <div class="admin-card__header">
                    <div>
                        <p class="admin-card__eyebrow">Report Result</p>
                        <h2>Output shown to the user</h2>
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <tbody>
                            @forelse ($cleanResult as $label => $value)
                                <tr>
                                    <th>{{ $label }}</th>
                                    <td>{{ $value }}</td>
                                </tr>
                            @empty
                                <tr><td>No result details available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </div>
@endsection
