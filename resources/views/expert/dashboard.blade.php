@extends('layouts.app')

@php($pageTitle = 'Expert Dashboard')
@php($pageSubtitle = 'Respond to open consultations and support farmers with crop guidance.')

@section('content')
    <div class="row g-4 mb-4">
        @foreach($analytics['totals'] as $label => $value)
            <div class="col-md-4">
                <div class="metric-card">
                    <h6>{{ str_replace('_', ' ', ucfirst($label)) }}</h6>
                    <div class="metric-value">{{ number_format($value) }}</div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="surface-card">
        <h4 class="mb-3">Latest consultations</h4>
        @foreach($latestQuestions as $question)
            <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom border-secondary-subtle' : '' }}">
                <div class="fw-semibold">{{ $question->title }}</div>
                <div class="small muted-label">{{ $question->farmer->name }} • {{ $question->crop?->title }}</div>
            </div>
        @endforeach
    </div>
@endsection
