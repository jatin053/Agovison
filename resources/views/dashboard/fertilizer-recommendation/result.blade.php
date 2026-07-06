@extends('dashboard_ui.layout')

@section('title', 'Fertilizer Result')
@section('subtitle', 'Review the saved fertilizer recommendation and safety guidance.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.fertilizer.history') }}">View History</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.fertilizer') }}">Create Another</a>
@endsection

@section('content')
    @include('dashboard.fertilizer-recommendation.partials.report', ['record' => $record])
@endsection
