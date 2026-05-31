<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiseaseReportRequest;
use App\Models\DiseaseReport;
use App\Services\DiseaseDetectionService;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DiseaseReportController extends Controller
{
    public function index(): View
    {
        return view('farmer.disease-reports.index', [
            'crops' => auth()->user()->crops()->approved()->get(),
            'reports' => auth()->user()->diseaseReports()->with('crop')->latest()->paginate(10),
        ]);
    }

    public function store(
        DiseaseReportRequest $request,
        DiseaseDetectionService $diseaseDetectionService,
        ImageUploadService $imageUploadService,
    ): RedirectResponse {
        $analysis = $diseaseDetectionService->analyze($request->file('image'), $request->input('notes'));
        $path = $request->hasFile('image')
            ? $imageUploadService->store($request->file('image'), 'disease-reports')
            : null;

        DiseaseReport::create([
            'user_id' => auth()->id(),
            'crop_id' => $request->input('crop_id'),
            'image_path' => $path,
            'predicted_disease' => $analysis['disease'],
            'confidence' => $analysis['confidence'],
            'symptoms' => $analysis['symptoms'],
            'cure' => $analysis['cure'],
            'fertilizer_recommendation' => $analysis['fertilizer_recommendation'],
            'notes' => $request->input('notes'),
            'status' => 'analyzed',
        ]);

        return back()->with('success', 'Disease report analyzed successfully.');
    }
}
