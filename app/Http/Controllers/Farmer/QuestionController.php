<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertQuestionRequest;
use App\Models\ExpertQuestion;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('farmer.questions.index', [
            'crops' => auth()->user()->crops()->approved()->get(),
            'experts' => User::role('Expert')->get(),
            'questions' => auth()->user()->expertQuestions()->with(['crop', 'expert', 'answers.expert'])->latest()->paginate(10),
        ]);
    }

    public function store(ExpertQuestionRequest $request): RedirectResponse
    {
        ExpertQuestion::create([
            'user_id' => auth()->id(),
            'crop_id' => $request->input('crop_id'),
            'expert_id' => User::role('Expert')->inRandomOrder()->value('id'),
            'title' => $request->input('title'),
            'question' => $request->input('question'),
            'priority' => $request->input('priority', 'medium'),
            'status' => 'open',
        ]);

        return back()->with('success', 'Your question has been submitted to the expert panel.');
    }
}
