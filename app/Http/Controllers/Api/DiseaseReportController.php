<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiseaseReportRequest;
use App\Models\DiseaseReport;
use App\Services\DiseaseDetectionService;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiseaseReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = DiseaseReport::query()->with(['farmer', 'crop']);

        if (! $request->user()->hasAnyRole(['Admin', 'Expert'])) {
            $query->where('user_id', $request->user()->id);
        }

        return response()->json([
            'data' => $query->latest()->get(),
        ]);
    }

    public function store(
        DiseaseReportRequest $request,
        DiseaseDetectionService $diseaseDetectionService,
        ImageUploadService $imageUploadService,
    ): JsonResponse {
        $analysis = $diseaseDetectionService->analyze($request->file('image'), $request->input('notes'));
        $path = $request->hasFile('image')
            ? $imageUploadService->store($request->file('image'), 'disease-reports')
            : null;

        $report = DiseaseReport::create([
            'user_id' => $request->user()->id,
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

        return response()->json([
            'message' => 'Disease report analyzed successfully.',
            'data' => $report,
        ], 201);
    }

    public function show(DiseaseReport $diseaseReport): JsonResponse
    {
        $this->authorize('view', $diseaseReport);

        return response()->json([
            'data' => $diseaseReport->load(['farmer', 'crop']),
        ]);
    }
}
