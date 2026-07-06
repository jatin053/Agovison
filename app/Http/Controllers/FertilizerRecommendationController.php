<?php

namespace App\Http\Controllers;

use App\Models\FertilizerRecommendation;
use App\Models\SoilProfile;
use App\Models\User;
use App\Services\FertilizerRecommendationService;
use App\Services\GoogleLocationService;
use App\Services\OpenWeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class FertilizerRecommendationController extends Controller
{
    private const CROPS = ['Wheat', 'Rice', 'Maize', 'Cotton', 'Sugarcane', 'Potato', 'Tomato', 'Mustard', 'Soybean', 'Other'];
    private const SEASONS = ['Rabi', 'Kharif', 'Zaid', 'Annual'];
    private const SOILS = [
        'Alluvial Soil', 'Black Soil', 'Cinder Soil', 'Clayey Soil', 'Laterite Soil',
        'Loamy Soil', 'Peat Soil', 'Sandy Loam', 'Sandy Soil', 'Yellow Soil',
        'Loamy', 'Clay', 'Sandy', 'Alluvial', 'Red Soil', 'Other',
    ];
    private const LEVELS = ['Low', 'Medium', 'High'];
    private const STAGES = ['Seedling', 'Vegetative', 'Flowering', 'Fruiting', 'Maturity'];
    private const PROBLEMS = ['Yellow Leaves', 'Slow Growth', 'Weak Roots', 'Low Flowering', 'Low Fruiting', 'Leaf Burning', 'Poor Plant Strength', 'No Visible Problem', 'Other'];
    private const IRRIGATION = ['Rainfed', 'Canal', 'Tube Well', 'Drip Irrigation', 'Sprinkler', 'Other'];
    private const ORGANIC = ['No Preference', 'Chemical Fertilizer', 'Organic Fertilizer', 'Integrated Nutrient Management'];

    public function __construct(
        private readonly FertilizerRecommendationService $recommendations,
        private readonly GoogleLocationService $locations,
        private readonly OpenWeatherService $weather,
    ) {
    }

    public function index(): View
    {
        return view('dashboard.fertilizer-recommendation.index', $this->formData() + [
            'records' => $this->currentUser()->fertilizerRecommendations()->latest()->take(5)->get(),
            'result' => session('fertilizer_result'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $record = $this->createRecommendation($request);
        } catch (RuntimeException $exception) {
            return back()->withInput()->withErrors(['current_problem' => $exception->getMessage()]);
        } catch (Throwable $exception) {
            Log::error('Fertilizer recommendation failed.', ['user_id' => Auth::id(), 'message' => $exception->getMessage()]);
            return back()->withInput()->withErrors(['current_problem' => 'Recommendation is temporarily unavailable. Please try again.']);
        }

        return redirect()->route('dashboard.fertilizer.result', $record)->with('status', 'Fertilizer recommendation saved.');
    }

    public function api(Request $request): JsonResponse
    {
        try {
            $record = $this->createRecommendation($request);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json([
            'id' => $record->id,
            'recommended_fertilizer' => $record->recommended_fertilizer_name,
            'type' => $record->fertilizer?->fertilizer_type,
            'confidence' => (float) $record->confidence,
            'reason' => $record->reason,
            'application_timing' => $record->application_timing,
            'general_guidance' => $record->general_guidance,
            'warnings' => $record->warnings,
            'alternatives' => $record->alternatives,
            'created_date' => $record->created_at?->toDateTimeString(),
        ]);
    }

    public function result(FertilizerRecommendation $fertilizerRecommendation): View
    {
        $this->ensureOwnRecord($fertilizerRecommendation);

        return view('dashboard.fertilizer-recommendation.result', ['record' => $fertilizerRecommendation]);
    }

    public function history(Request $request): View
    {
        $query = $this->currentUser()->fertilizerRecommendations()->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(fn ($builder) => $builder->where('crop_name', 'like', '%'.$search.'%')
                ->orWhere('recommended_fertilizer_name', 'like', '%'.$search.'%')
                ->orWhere('recommended_fertilizer', 'like', '%'.$search.'%'));
        }
        if ($request->filled('soil_type')) {
            $query->where('soil_type', $request->string('soil_type')->toString());
        }
        if ($request->filled('confidence_min')) {
            $query->where('confidence', '>=', (float) $request->input('confidence_min'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        return view('dashboard.fertilizer-recommendation.history', [
            'records' => $query->paginate(10)->withQueryString(),
            'soilTypes' => self::SOILS,
        ]);
    }

    public function show(FertilizerRecommendation $fertilizerRecommendation): View
    {
        $this->ensureOwnRecord($fertilizerRecommendation);

        return view('dashboard.fertilizer-recommendation.show', ['record' => $fertilizerRecommendation]);
    }

    public function destroy(FertilizerRecommendation $fertilizerRecommendation): RedirectResponse
    {
        $this->ensureOwnRecord($fertilizerRecommendation);
        $fertilizerRecommendation->delete();

        return redirect()->route('dashboard.fertilizer.history')->with('status', 'Fertilizer report deleted.');
    }

    private function createRecommendation(Request $request): FertilizerRecommendation
    {
        $data = $this->validated($request);
        $data = $this->withSoilProfile($data);
        $data = $this->withWeather($data);
        $result = $this->recommendations->recommend($data);
        $fertilizer = $result['fertilizer'] ?? null;

        return FertilizerRecommendation::create([
            'user_id' => $this->currentUser()->getKey(),
            'soil_profile_id' => $data['soil_profile_id'] ?? null,
            'soil_snapshot' => $data['soil_snapshot'] ?? null,
            'crop_name' => $data['crop_name'],
            'location' => $data['location_name'] ?? null,
            'location_name' => $data['location_name'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'season' => $data['season'] ?? null,
            'soil_type' => $data['soil_type'],
            'ph_value' => $data['ph_value'] ?? null,
            'nitrogen_level' => $data['nitrogen_level'] ?? null,
            'phosphorus_level' => $data['phosphorus_level'] ?? null,
            'potassium_level' => $data['potassium_level'] ?? null,
            'nitrogen_value' => $data['nitrogen_value'] ?? null,
            'phosphorus_value' => $data['phosphorus_value'] ?? null,
            'potassium_value' => $data['potassium_value'] ?? null,
            'growth_stage' => $data['growth_stage'] ?? null,
            'current_problem' => $data['current_problem'] ?? null,
            'irrigation_type' => $data['irrigation_type'] ?? null,
            'previous_fertilizer' => $data['previous_fertilizer'] ?? null,
            'last_application_date' => $data['last_application_date'] ?? null,
            'organic_preference' => $data['organic_preference'] ?? null,
            'notes' => $data['notes'] ?? null,
            'temperature' => $data['temperature'] ?? null,
            'humidity' => $data['humidity'] ?? null,
            'rainfall' => $data['rainfall'] ?? null,
            'weather_condition' => $data['weather_condition'] ?? null,
            'recommended_fertilizer_id' => $fertilizer?->id,
            'recommended_fertilizer_name' => $result['recommended_fertilizer'],
            'recommended_fertilizer' => $result['recommended_fertilizer'],
            'confidence' => $result['confidence'],
            'reason' => $result['reason'],
            'dosage_advice' => $result['general_guidance'],
            'application_timing' => $result['application_timing'],
            'general_guidance' => $result['general_guidance'],
            'warnings' => $result['warnings'],
            'alternatives' => $result['alternatives'],
            'recommendation_source' => $result['recommendation_source'],
            'status' => $result['status'],
            'caution' => implode(' ', $result['warnings']),
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'crop_name' => ['required', Rule::in(self::CROPS)],
            'location_name' => ['required', 'string', 'max:191'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'season' => ['nullable', Rule::in(self::SEASONS)],
            'soil_profile_id' => ['nullable', 'exists:soil_profiles,id'],
            'soil_type' => ['required_without:soil_profile_id', 'nullable', Rule::in(self::SOILS)],
            'ph_value' => ['nullable', 'numeric', 'between:0,14'],
            'nitrogen_level' => ['nullable', Rule::in(self::LEVELS)],
            'phosphorus_level' => ['nullable', Rule::in(self::LEVELS)],
            'potassium_level' => ['nullable', Rule::in(self::LEVELS)],
            'nitrogen_value' => ['nullable', 'numeric', 'min:0'],
            'phosphorus_value' => ['nullable', 'numeric', 'min:0'],
            'potassium_value' => ['nullable', 'numeric', 'min:0'],
            'growth_stage' => ['nullable', Rule::in(self::STAGES)],
            'current_problem' => ['nullable', Rule::in(self::PROBLEMS)],
            'irrigation_type' => ['nullable', Rule::in(self::IRRIGATION)],
            'previous_fertilizer' => ['nullable', 'string', 'max:191'],
            'last_application_date' => ['nullable', 'date', 'before_or_equal:today'],
            'organic_preference' => ['nullable', Rule::in(self::ORGANIC)],
            'notes' => ['nullable', 'string', 'max:3000'],
            'temperature' => ['nullable', 'numeric'],
            'humidity' => ['nullable', 'numeric'],
            'rainfall' => ['nullable', 'numeric'],
            'weather_condition' => ['nullable', 'string', 'max:191'],
        ]);

        if (blank($data['current_problem'] ?? null)
            && blank($data['nitrogen_level'] ?? null) && blank($data['phosphorus_level'] ?? null) && blank($data['potassium_level'] ?? null)
            && ! isset($data['nitrogen_value']) && ! isset($data['phosphorus_value']) && ! isset($data['potassium_value'])) {
            throw new RuntimeException('Add NPK level/value or a visible crop problem before requesting a recommendation.');
        }

        return $data;
    }

    private function withSoilProfile(array $data): array
    {
        if (empty($data['soil_profile_id'])) {
            $data['soil_snapshot'] = collect($data)->only(['soil_type', 'ph_value', 'nitrogen_level', 'phosphorus_level', 'potassium_level', 'nitrogen_value', 'phosphorus_value', 'potassium_value'])->all();
            return $data;
        }

        $profile = SoilProfile::where('user_id', $this->currentUser()->getKey())->findOrFail($data['soil_profile_id']);
        $data['soil_type'] = $profile->soil_type;
        $data['ph_value'] = $profile->ph_value ?? $data['ph_value'] ?? null;
        $data['nitrogen_level'] = $profile->nitrogen_level ?? $data['nitrogen_level'] ?? null;
        $data['phosphorus_level'] = $profile->phosphorus_level ?? $data['phosphorus_level'] ?? null;
        $data['potassium_level'] = $profile->potassium_level ?? $data['potassium_level'] ?? null;
        $data['nitrogen_value'] = $profile->nitrogen_value ?? $data['nitrogen_value'] ?? null;
        $data['phosphorus_value'] = $profile->phosphorus_value ?? $data['phosphorus_value'] ?? null;
        $data['potassium_value'] = $profile->potassium_value ?? $data['potassium_value'] ?? null;
        $data['location_name'] = $data['location_name'] ?? $profile->location ?? null;
        $data['soil_snapshot'] = $profile->snapshot();

        return $data;
    }

    private function withWeather(array $data): array
    {
        if (! empty($data['temperature'])) {
            return $data;
        }

        try {
            if (empty($data['latitude']) || empty($data['longitude'])) {
                $location = $this->locations->geocode($data['location_name']);
                if (! $location) {
                    throw new RuntimeException('Location could not be found. Enter a city, village, or use current location.');
                }
                $data['location_name'] = $location['name'];
                $data['latitude'] = $location['latitude'];
                $data['longitude'] = $location['longitude'];
            } elseif (str_starts_with(strtolower($data['location_name']), 'current location')) {
                $location = $this->locations->reverseGeocode((float) $data['latitude'], (float) $data['longitude']);
                $data['location_name'] = $location['name'] ?? $data['location_name'];
            }

            $weather = $this->weather->current((float) $data['latitude'], (float) $data['longitude']);
            foreach (['temperature', 'humidity', 'rainfall', 'weather_condition'] as $field) {
                $data[$field] = $weather[$field] ?? null;
            }
        } catch (Throwable $exception) {
            Log::warning('Fertilizer weather lookup failed.', ['message' => $exception->getMessage()]);
        }

        return $data;
    }

    private function formData(): array
    {
        return [
            'soilProfiles' => $this->currentUser()->soilProfiles()->latest()->get(),
            'crops' => self::CROPS,
            'seasons' => self::SEASONS,
            'soils' => self::SOILS,
            'levels' => self::LEVELS,
            'stages' => self::STAGES,
            'problems' => self::PROBLEMS,
            'irrigationTypes' => self::IRRIGATION,
            'organicPreferences' => self::ORGANIC,
        ];
    }

    private function ensureOwnRecord(FertilizerRecommendation $record): void
    {
        abort_unless((int) $record->user_id === (int) $this->currentUser()->getKey(), 403);
    }

    private function currentUser(): User
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        return $user;
    }
}
