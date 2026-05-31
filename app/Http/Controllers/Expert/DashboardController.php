<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\ExpertQuestion;
use App\Services\AnalyticsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(AnalyticsService $analyticsService): View
    {
        return view('expert.dashboard', [
            'analytics' => $analyticsService->expert(auth()->user()),
            'latestQuestions' => ExpertQuestion::with(['farmer', 'crop'])
                ->where(function ($query) {
                    $query->whereNull('expert_id')->orWhere('expert_id', auth()->id());
                })
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}
