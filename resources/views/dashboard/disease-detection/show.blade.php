@extends('dashboard_ui.layout')

@section('title', 'Disease Report Details')
@section('subtitle', 'Open a saved report and review the full disease assessment.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.disease.history') }}">Back to History</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.disease') }}">Detect Another Disease</a>
@endsection

@section('content')
    @include('dashboard.disease-detection.partials.report', ['record' => $record])
@endsection
