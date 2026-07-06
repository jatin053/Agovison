@extends('dashboard_ui.layout')

@section('title', 'Disease Result')
@section('subtitle', 'Review the latest disease report, alternatives, and treatment guidance.')

@section('header_actions')
    <a class="dash-button dash-button--ghost" href="{{ route('dashboard.disease') }}">Detect Another Disease</a>
    <a class="dash-button dash-button--primary" href="{{ route('dashboard.disease.history') }}">Open History</a>
@endsection

@section('content')
    @include('dashboard.disease-detection.partials.report', ['record' => $record])
@endsection
