@extends('layouts.app')

@php($pageTitle = 'Consultation Inbox')
@php($pageSubtitle = 'Answer farmer questions in a chat-style workflow with solution tagging.')

@section('content')
    @foreach($questions as $question)
        <div class="surface-card mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $question->title }}</h5>
                    <div class="small muted-label">{{ $question->farmer->name }} • {{ $question->crop?->title }} • {{ ucfirst($question->status) }}</div>
                </div>
                <span class="badge-soft">{{ ucfirst($question->priority) }}</span>
            </div>
            <p class="mt-3">{{ $question->question }}</p>
            <div class="mini-card mb-3">
                @forelse($question->answers as $answer)
                    <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom border-secondary-subtle' : '' }}">
                        <div class="fw-semibold">{{ $answer->expert->name }} @if($answer->is_solution)<span class="badge-soft ms-2">Solution</span>@endif</div>
                        <div class="muted-label">{{ $answer->answer }}</div>
                    </div>
                @empty
                    <div class="muted-label">No expert reply yet.</div>
                @endforelse
            </div>
            <form action="{{ route('expert.questions.answer', $question) }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-9"><textarea class="form-control" name="answer" rows="3" placeholder="Write your consultation response"></textarea></div>
                <div class="col-md-3 d-flex flex-column gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_solution" value="1" id="solution_{{ $question->id }}">
                        <label class="form-check-label" for="solution_{{ $question->id }}">Mark as solution</label>
                    </div>
                    <button class="btn btn-success w-100">Post reply</button>
                </div>
            </form>
        </div>
    @endforeach
    <div class="mt-4">{{ $questions->links() }}</div>
@endsection
