@extends('layouts.app')

@php($pageTitle = 'Reports Center')
@php($pageSubtitle = 'Review disease analysis and expert consultations across the platform.')

@section('content')
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="table-surface">
                <h4 class="mb-3">Disease reports</h4>
                @foreach($diseaseReports as $report)
                    <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom border-secondary-subtle' : '' }}">
                        <div class="fw-semibold">{{ $report->predicted_disease ?? 'Pending analysis' }}</div>
                        <div class="small muted-label">{{ $report->farmer->name }} • {{ $report->crop?->title }}</div>
                        <div class="small">{{ $report->cure }}</div>
                    </div>
                @endforeach
                <div class="mt-4">{{ $diseaseReports->links() }}</div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="table-surface">
                <h4 class="mb-3">Expert questions</h4>
                @foreach($expertQuestions as $question)
                    <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom border-secondary-subtle' : '' }}">
                        <div class="fw-semibold">{{ $question->title }}</div>
                        <div class="small muted-label">{{ $question->farmer->name }} • {{ ucfirst($question->status) }}</div>
                        <div class="small">{{ \Illuminate\Support\Str::limit($question->question, 120) }}</div>
                    </div>
                @endforeach
                <div class="mt-4">{{ $expertQuestions->links() }}</div>
            </div>
        </div>
    </div>
@endsection
