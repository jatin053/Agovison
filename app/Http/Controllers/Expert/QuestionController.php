<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertAnswerRequest;
use App\Models\ExpertQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('expert.questions.index', [
            'questions' => ExpertQuestion::with(['farmer', 'crop', 'answers.expert'])
                ->where(function ($query) {
                    $query->whereNull('expert_id')->orWhere('expert_id', auth()->id());
                })
                ->latest()
                ->paginate(10),
        ]);
    }

    public function answer(ExpertAnswerRequest $request, ExpertQuestion $question): RedirectResponse
    {
        $question->update([
            'expert_id' => auth()->id(),
            'status' => $request->boolean('is_solution') ? 'answered' : 'open',
            'answered_at' => now(),
        ]);

        $question->answers()->create([
            'expert_id' => auth()->id(),
            'answer' => $request->input('answer'),
            'is_solution' => $request->boolean('is_solution'),
        ]);

        return back()->with('success', 'Expert response posted successfully.');
    }
}
