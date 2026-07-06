<?php

namespace App\Http\Controllers;

use App\Models\DiseaseDetection;
use App\Models\User;
use App\Services\DiseaseDetectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class DiseaseDetectionController extends Controller
{
    public function __construct(
        private readonly DiseaseDetectionService $diseaseDetectionService,
    ) {
    }

    public function index(): View
    {
        $user = $this->currentUser();
        $recentReports = $user->diseaseDetections()->latest()->take(4)->get();
        $latestReport = $recentReports->first();

        return view('dashboard.disease-detection.index', [
            'supportedCrops' => ['Tomato', 'Potato', 'Rice', 'Wheat', 'Maize'],
            'affectedParts' => ['Leaf', 'Stem', 'Fruit', 'Root', 'Whole Plant'],
            'symptomOptions' => ['Yellow Leaves', 'Brown Spots', 'Black Spots', 'White Powder', 'Leaf Curling', 'Holes', 'Wilting', 'Rotting', 'Weak Growth', 'Other'],
            'totalChecks' => $user->diseaseDetections()->count(),
            'latestReport' => $latestReport,
            'recentReports' => $recentReports,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'crop_name' => ['required', Rule::in(['Tomato', 'Potato', 'Rice', 'Wheat', 'Maize'])],
            'leaf_image' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'affected_part' => ['required', Rule::in(['Leaf', 'Stem', 'Fruit', 'Root', 'Whole Plant'])],
            'symptoms' => ['required', Rule::in(['Yellow Leaves', 'Brown Spots', 'Black Spots', 'White Powder', 'Leaf Curling', 'Holes', 'Wilting', 'Rotting', 'Weak Growth', 'Other'])],
            'location' => ['required', 'string', 'max:191'],
            'crop_age' => ['required', 'string', 'max:80'],
            'symptom_started' => ['required', 'date'],
            'field_affected' => ['required', 'numeric', 'min:0', 'max:100'],
            'fertilizer_used' => ['nullable', 'string', 'max:2000'],
            'pesticide_used' => ['nullable', 'string', 'max:2000'],
        ]);

        $image = $request->file('leaf_image');
        $fileName = Str::uuid().'.'.$image->extension();
        $imagePath = $image->storePubliclyAs('disease-images', $fileName, 'public');
        $user = $this->currentUser();

        try {
            $prediction = $this->diseaseDetectionService->predict($validated, $image);

            $record = DiseaseDetection::create([
                'user_id' => $user->getKey(),
                'crop_name' => $validated['crop_name'],
                'image_path' => $imagePath,
                'leaf_image_path' => $imagePath,
                'affected_part' => $validated['affected_part'],
                'symptoms' => $validated['symptoms'],
                'location' => $validated['location'],
                'crop_age' => $validated['crop_age'],
                'symptom_started' => $validated['symptom_started'],
                'field_affected' => $validated['field_affected'],
                'fertilizer_used' => $validated['fertilizer_used'] ?? null,
                'pesticide_used' => $validated['pesticide_used'] ?? null,
                'disease_name' => $prediction['disease_name'],
                'detected_disease' => $prediction['disease_name'],
                'confidence' => $prediction['confidence'],
                'confidence_score' => max(0, min(100, (int) round($prediction['confidence']))),
                'severity' => $prediction['severity'],
                'possible_cause' => $prediction['possible_cause'],
                'treatment' => $prediction['treatment'],
                'treatment_suggestion' => $prediction['treatment'],
                'prevention' => $prediction['prevention'],
                'alternatives' => $prediction['alternatives'],
                'status' => $prediction['status'],
                'analysis_source' => $prediction['analysis_source'] ?? 'python_api',
                'raw_response' => $prediction['raw_response'] ?? null,
            ]);

            return redirect()
                ->route('dashboard.disease.result', $record)
                ->with('status', 'Disease report saved successfully.');
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($imagePath);

            Log::error('Disease detection failed.', [
                'user_id' => $user->getKey(),
                'crop_name' => $validated['crop_name'],
                'location' => $validated['location'],
                'message' => $exception->getMessage(),
            ]);

            return back()
                ->withInput($request->except('leaf_image'))
                ->withErrors([
                    'leaf_image' => app()->isLocal()
                        ? $exception->getMessage()
                        : 'Disease detection is temporarily unavailable. Please try again later.',
                ]);
        }
    }

    public function result(DiseaseDetection $diseaseDetection): View
    {
        $this->ensureOwnRecord($diseaseDetection);

        return view('dashboard.disease-detection.result', [
            'record' => $diseaseDetection,
        ]);
    }

    public function history(Request $request): View
    {
        $query = $this->currentUser()
            ->diseaseDetections()
            ->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('crop_name', 'like', '%'.$search.'%')
                    ->orWhere('disease_name', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        return view('dashboard.disease-detection.history', [
            'records' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function show(DiseaseDetection $diseaseDetection): View
    {
        $this->ensureOwnRecord($diseaseDetection);

        return view('dashboard.disease-detection.show', [
            'record' => $diseaseDetection,
        ]);
    }

    public function destroy(DiseaseDetection $diseaseDetection): RedirectResponse
    {
        $this->ensureOwnRecord($diseaseDetection);

        Storage::disk('public')->delete($diseaseDetection->image_path ?: $diseaseDetection->leaf_image_path);
        $diseaseDetection->delete();

        return redirect()
            ->route('dashboard.disease.history')
            ->with('status', 'Disease report deleted.');
    }

    private function ensureOwnRecord(DiseaseDetection $diseaseDetection): void
    {
        $user = $this->currentUser();

        abort_unless((int) $diseaseDetection->getAttribute('user_id') === (int) $user->getKey() || $user->isAdmin(), 403);
    }

    private function currentUser(): User
    {
        $user = Auth::user();

        abort_unless($user instanceof User, 403);

        return $user;
    }
}
