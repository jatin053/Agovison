<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiseaseReport;
use App\Models\ExpertQuestion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.reports.index', [
            'diseaseReports' => DiseaseReport::with(['farmer', 'crop'])->latest()->paginate(8, ['*'], 'disease_page'),
            'expertQuestions' => ExpertQuestion::with(['farmer', 'expert', 'crop'])->latest()->paginate(8, ['*'], 'question_page'),
        ]);
    }
}
