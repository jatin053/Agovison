@extends('layouts.app')

@php($pageTitle = 'Expert Advisory')
@php($pageSubtitle = 'Ask specialists about crop health, disease treatment, and cultivation strategy.')

@section('content')
    <div class="surface-card mb-4">
        <form action="{{ route('farmer.questions.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <select class="form-select" name="crop_id">
                    <option value="">Select crop</option>
                    @foreach($crops as $crop)
                        <option value="{{ $crop->id }}">{{ $crop->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4"><input class="form-control" name="title" placeholder="Question title"></div>
            <div class="col-md-4"><select class="form-select" name="priority"><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option></select></div>
            <div class="col-12"><textarea class="form-control" rows="4" name="question" placeholder="Describe the issue or consultation topic"></textarea></div>
            <div class="col-12"><button class="btn btn-success">Send to experts</button></div>
        </form>
    </div>
    @foreach($questions as $question)
        <div class="surface-card mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $question->title }}</h5>
                    <div class="small muted-label">{{ ucfirst($question->status) }} • {{ ucfirst($question->priority) }} priority</div>
                </div>
                <span class="badge-soft">{{ $question->crop?->title }}</span>
            </div>
            <p class="mt-3">{{ $question->question }}</p>
            <div class="border-top border-secondary-subtle pt-3 mt-3">
                @forelse($question->answers as $answer)
                    <div class="{{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="fw-semibold">{{ $answer->expert->name }} @if($answer->is_solution)<span class="badge-soft ms-2">Solution</span>@endif</div>
                        <p class="mb-0 muted-label">{{ $answer->answer }}</p>
                    </div>
                @empty
                    <div class="muted-label">Awaiting expert response.</div>
                @endforelse
            </div>
        </div>
    @endforeach
    <div class="mt-4">{{ $questions->links() }}</div>
@endsection
