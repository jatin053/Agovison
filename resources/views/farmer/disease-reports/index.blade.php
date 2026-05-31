@extends('layouts.app')

@php($pageTitle = 'Disease Detection')
@php($pageSubtitle = 'Upload crop images for demo AI diagnosis and save treatment recommendations.')

@section('content')
    <div class="surface-card mb-4">
        <form action="{{ route('farmer.disease-reports.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-4">
                <select class="form-select" name="crop_id">
                    <option value="">Select crop</option>
                    @foreach($crops as $crop)
                        <option value="{{ $crop->id }}">{{ $crop->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4"><input class="form-control" type="file" name="image"></div>
            <div class="col-md-4"><button class="btn btn-success w-100">Analyze Leaf</button></div>
            <div class="col-12"><textarea class="form-control" rows="3" name="notes" placeholder="Optional notes for the expert or diagnosis context"></textarea></div>
        </form>
    </div>
    <div class="row g-4">
        @foreach($reports as $report)
            <div class="col-lg-6">
                <div class="surface-card h-100">
                    <h5>{{ $report->predicted_disease }}</h5>
                    <div class="small muted-label">{{ $report->crop?->title }} • Confidence {{ number_format((float) $report->confidence, 2) }}%</div>
                    <p class="mt-3 mb-2"><strong>Symptoms:</strong> {{ $report->symptoms }}</p>
                    <p class="mb-2"><strong>Cure:</strong> {{ $report->cure }}</p>
                    <p class="mb-0"><strong>Fertilizer:</strong> {{ $report->fertilizer_recommendation }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $reports->links() }}</div>
@endsection
