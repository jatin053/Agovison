@extends('dashboard_ui.layout')

@section('title', 'Fertilizer Report')
@section('subtitle', 'Saved fertilizer recommendation details.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.fertilizer.history') }}">Back</a>
@endsection

@section('content')
    @include('dashboard.fertilizer-recommendation.partials.report', ['record' => $record])
@endsection
