<?php

namespace App\Http\Controllers;

use App\Models\SoilProfile;
use App\Models\User;
use App\Services\SoilDataService;
use App\Services\SoilImageAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class SoilProfileController extends Controller
{
    private const SOIL_TYPES = [
        'Alluvial Soil', 'Black Soil', 'Cinder Soil', 'Clayey Soil', 'Laterite Soil',
        'Loamy Soil', 'Peat Soil', 'Sandy Loam', 'Sandy Soil', 'Yellow Soil',
        'Loamy', 'Clay', 'Sandy', 'Alluvial', 'Red Soil', 'Other',
    ];
    private const NPK_LEVELS = ['Low', 'Medium', 'High'];
    private const SOURCES = ['Manual Entry', 'Soil Test Report', 'Estimated From Location', 'Admin Reviewed'];

    private const CROPS = ['Rice', 'Wheat', 'Maize', 'Potato', 'Tomato', 'Cotton', 'Sugarcane', 'Soybean', 'Groundnut', 'Mustard', 'Millet', 'Vegetables', 'Tea', 'Coffee', 'Other'];

    public function __construct(
        private readonly SoilDataService $soilData,
        private readonly SoilImageAnalysisService $soilImages,
    ) {}

    public function index(): View
    {
        return view('dashboard.soil.index', [
            'profiles' => $this->currentUser()->soilProfiles()->latest()->take(6)->get(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.soil.form', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $image = $request->file('soil_image');
        $imagePath = $image->storePubliclyAs('soil-images', Str::uuid().'.'.$image->extension(), 'public');

        try {
            $prediction = $this->soilImages->predict($image);
            $profile = SoilProfile::create([
                'user_id' => $this->currentUser()->getKey(),
                'crop_name' => $data['crop_name'],
                'soil_image_path' => $imagePath,
                'soil_type' => $prediction['soil_type'],
                'confidence' => $prediction['confidence'],
                'crop_advice' => $this->cropAdvice($prediction['soil_type'], $data['crop_name']),
                'data_source' => 'Image AI Estimate',
                'analysis_source' => $prediction['analysis_source'],
                'api_provider' => $prediction['analysis_source'],
                'api_response' => $prediction['raw_response'],
            ]);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($imagePath);
            Log::warning('Soil image analysis failed.', [
                'user_id' => Auth::id(),
                'message' => $exception->getMessage(),
            ]);

            return back()->withInput()->withErrors([
                'soil_image' => app()->isLocal()
                    ? $exception->getMessage()
                    : 'Soil image analysis is temporarily unavailable.',
            ]);
        }

        return redirect()->route('dashboard.soil.show', $profile)->with('status', 'Soil profile saved successfully.');
    }

    public function show(SoilProfile $soilProfile): View
    {
        $this->ensureOwnProfile($soilProfile);

        return view('dashboard.soil.show', [
            'profile' => $soilProfile,
        ]);
    }

    public function edit(SoilProfile $soilProfile): View
    {
        $this->ensureOwnProfile($soilProfile);

        return view('dashboard.soil.form', $this->formData($soilProfile));
    }

    public function update(Request $request, SoilProfile $soilProfile): RedirectResponse
    {
        $this->ensureOwnProfile($soilProfile);
        $data = $this->validated($request, false);
        $updates = [
            'crop_name' => $data['crop_name'],
            'crop_advice' => $this->cropAdvice($soilProfile->soil_type, $data['crop_name']),
        ];

        if ($request->hasFile('soil_image')) {
            $image = $request->file('soil_image');
            $newPath = $image->storePubliclyAs('soil-images', Str::uuid().'.'.$image->extension(), 'public');

            try {
                $prediction = $this->soilImages->predict($image);
                $updates += [
                    'soil_image_path' => $newPath,
                    'soil_type' => $prediction['soil_type'],
                    'confidence' => $prediction['confidence'],
                    'crop_advice' => $this->cropAdvice($prediction['soil_type'], $data['crop_name']),
                    'data_source' => 'Image AI Estimate',
                    'analysis_source' => $prediction['analysis_source'],
                    'api_provider' => $prediction['analysis_source'],
                    'api_response' => $prediction['raw_response'],
                ];
            } catch (Throwable $exception) {
                Storage::disk('public')->delete($newPath);
                return back()->withInput()->withErrors(['soil_image' => $exception->getMessage()]);
            }

            Storage::disk('public')->delete($soilProfile->soil_image_path);
        }

        $soilProfile->update($updates);

        return redirect()->route('dashboard.soil.show', $soilProfile)->with('status', 'Soil profile updated.');
    }

    public function destroy(SoilProfile $soilProfile): RedirectResponse
    {
        $this->ensureOwnProfile($soilProfile);
        Storage::disk('public')->delete($soilProfile->soil_image_path);
        $soilProfile->delete();

        return redirect()->route('dashboard.soil.history')->with('status', 'Soil profile deleted.');
    }

    public function history(Request $request): View
    {
        $query = $this->currentUser()->soilProfiles()->latest();

        if ($request->filled('soil_type')) {
            $query->where('soil_type', $request->string('soil_type')->toString());
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->string('location')->toString().'%');
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }

        return view('dashboard.soil.history', [
            'profiles' => $query->paginate(10)->withQueryString(),
            'soilTypes' => self::SOIL_TYPES,
        ]);
    }

    public function estimate(Request $request): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        try {
            return response()->json([
                'ok' => true,
                'data' => $this->soilData->estimate((float) $data['latitude'], (float) $data['longitude']),
                'message' => 'Estimated soil data loaded. Please verify and correct it before saving.',
            ]);
        } catch (Throwable $exception) {
            Log::warning('Soil estimate failed.', [
                'user_id' => Auth::id(),
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Soil estimation is unavailable. Continue with manual soil entry.',
            ], 200);
        }
    }

    private function formData(?SoilProfile $profile = null): array
    {
        return [
            'profile' => $profile,
            'soilTypes' => self::SOIL_TYPES,
            'npkLevels' => self::NPK_LEVELS,
            'sources' => self::SOURCES,
            'crops' => self::CROPS,
        ];
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        return $request->validate([
            'crop_name' => ['required', 'string', 'max:120'],
            'soil_image' => [$imageRequired ? 'required' : 'nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    private function cropAdvice(string $soilType, string $crop): string
    {
        $recommended = match (strtolower($soilType)) {
            'alluvial soil' => ['Rice', 'Wheat', 'Maize', 'Sugarcane', 'Vegetables'],
            'black soil' => ['Cotton', 'Soybean', 'Wheat', 'Sugarcane'],
            'clayey soil' => ['Rice', 'Wheat'],
            'laterite soil' => ['Tea', 'Coffee', 'Groundnut'],
            'loamy soil' => ['Wheat', 'Maize', 'Potato', 'Tomato', 'Vegetables'],
            'peat soil' => ['Rice', 'Vegetables'],
            'sandy loam' => ['Potato', 'Groundnut', 'Maize', 'Vegetables'],
            'sandy soil' => ['Groundnut', 'Millet', 'Vegetables'],
            'yellow soil' => ['Groundnut', 'Millet', 'Mustard'],
            default => ['Maize', 'Millet', 'Groundnut'],
        };

        if (in_array($crop, $recommended, true)) {
            return "{$crop} is generally compatible with visually identified {$soilType}. Confirm pH and nutrients with a laboratory soil test before fertilizer planning.";
        }

        return "{$crop} may need extra soil management in {$soilType}. Commonly suitable crops include ".implode(', ', $recommended).'. Confirm with a laboratory soil test and local agriculture expert.';
    }

    private function ensureOwnProfile(SoilProfile $soilProfile): void
    {
        abort_unless((int) $soilProfile->user_id === (int) $this->currentUser()->getKey(), 403);
    }

    private function currentUser(): User
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        return $user;
    }
}
