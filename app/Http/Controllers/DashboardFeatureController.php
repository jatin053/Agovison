<?php

namespace App\Http\Controllers;

use App\Models\CropRecommendation;
use App\Models\FertilizerRecommendation;
use App\Models\SoilProfile;
use App\Models\WeatherData;
use App\Models\WeatherSearch;
use App\Models\YieldPrediction;
use App\Services\GoogleAirQualityService;
use App\Services\GoogleLocationService;
use App\Services\OpenWeatherService;
use App\Services\RecommendationEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class DashboardFeatureController extends Controller
{
    public function __construct(
        private readonly GoogleLocationService $locations,
        private readonly OpenWeatherService $weather,
        private readonly GoogleAirQualityService $airQuality,
        private readonly RecommendationEngine $engine,
    ) {
    }

    public function crop(): View
    {
        return view('dashboard_ui.crop', [
            'records' => CropRecommendation::where('user_id', $this->userId())->latest()->take(6)->get(),
            'result' => session('crop_result'),
        ]);
    }

    public function storeCrop(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'crop_name' => ['nullable', 'string', 'max:191'],
            'location_name' => ['required', 'string', 'max:191'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'soil_type' => ['required', 'string', 'max:80'],
            'temperature' => ['nullable', 'numeric'],
            'humidity' => ['nullable', 'numeric'],
            'rainfall' => ['nullable', 'numeric'],
            'ph_value' => ['required', 'numeric', 'between:0,14'],
            'nitrogen' => ['required', 'numeric', 'min:0'],
            'phosphorus' => ['required', 'numeric', 'min:0'],
            'potassium' => ['required', 'numeric', 'min:0'],
            'season' => ['required', 'string', 'max:80'],
        ]);

        $data = $this->withLocationAndWeather($data);
        $record = CropRecommendation::create($this->cropPayload($data) + $this->engine->crop($data) + ['user_id' => $this->userId()]);

        return back()->with('crop_result', $record->fresh());
    }

    public function yield(): View
    {
        return view('dashboard_ui.yield', [
            'records' => YieldPrediction::where('user_id', $this->userId())->latest()->take(6)->get(),
            'result' => session('yield_result'),
            'soilProfiles' => SoilProfile::where('user_id', $this->userId())->latest()->get(),
            'selectedSoilProfile' => request('soil_profile_id'),
        ]);
    }

    public function storeYield(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'crop_name' => ['required', 'string', 'max:191'],
            'location_name' => ['required', 'string', 'max:191'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'land_area' => ['required', 'numeric', 'min:0.01'],
            'area_unit' => ['required', 'string', 'max:40'],
            'season' => ['required', 'string', 'max:80'],
            'soil_type' => ['required_without:soil_profile_id', 'nullable', 'string', 'max:80'],
            'irrigation_type' => ['required', 'string', 'max:100'],
            'previous_crop' => ['nullable', 'string', 'max:191'],
            'temperature' => ['nullable', 'numeric'],
            'humidity' => ['nullable', 'numeric'],
            'rainfall' => ['nullable', 'numeric'],
            'soil_mode' => ['nullable', 'string', 'max:80'],
            'soil_profile_id' => ['nullable', 'exists:soil_profiles,id'],
            'ph_value' => ['nullable', 'numeric', 'between:0,14'],
            'nitrogen_level' => ['nullable', 'string', 'max:20'],
            'phosphorus_level' => ['nullable', 'string', 'max:20'],
            'potassium_level' => ['nullable', 'string', 'max:20'],
            'organic_carbon' => ['nullable', 'numeric', 'min:0'],
            'soil_moisture' => ['nullable', 'numeric', 'between:0,100'],
        ]);

        $data = $this->withSoilProfile($data);
        $data = $this->withLocationAndWeather($data);
        $record = YieldPrediction::create($this->yieldPayload($data) + $this->engine->yield($data) + ['user_id' => $this->userId()]);

        return back()->with('yield_result', $record->fresh());
    }

    public function fertilizer(): View
    {
        return view('dashboard_ui.fertilizer', [
            'records' => FertilizerRecommendation::where('user_id', $this->userId())->latest()->take(6)->get(),
            'result' => session('fertilizer_result'),
            'soilProfiles' => SoilProfile::where('user_id', $this->userId())->latest()->get(),
            'selectedSoilProfile' => request('soil_profile_id'),
        ]);
    }

    public function storeFertilizer(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'crop_name' => ['required', 'string', 'max:191'],
            'location_name' => ['required', 'string', 'max:191'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'soil_type' => ['required_without:soil_profile_id', 'nullable', 'string', 'max:80'],
            'season' => ['required', 'string', 'max:80'],
            'growth_stage' => ['required', 'string', 'max:120'],
            'nitrogen_level' => ['required_without:soil_profile_id', 'nullable', 'numeric', 'min:0'],
            'phosphorus_level' => ['required_without:soil_profile_id', 'nullable', 'numeric', 'min:0'],
            'potassium_level' => ['required_without:soil_profile_id', 'nullable', 'numeric', 'min:0'],
            'ph_value' => ['required_without:soil_profile_id', 'nullable', 'numeric', 'between:0,14'],
            'current_problem' => ['nullable', 'string', 'max:2000'],
            'soil_mode' => ['nullable', 'string', 'max:80'],
            'soil_profile_id' => ['nullable', 'exists:soil_profiles,id'],
            'organic_carbon' => ['nullable', 'numeric', 'min:0'],
            'soil_moisture' => ['nullable', 'numeric', 'between:0,100'],
        ]);

        $data = $this->withSoilProfile($data);
        $data = $this->withLocationAndWeather($data);
        $record = FertilizerRecommendation::create($this->fertilizerPayload($data) + $this->engine->fertilizer($data) + ['user_id' => $this->userId()]);

        return back()->with('fertilizer_result', $record->fresh());
    }

    public function weather(): View
    {
        return view('dashboard_ui.weather', [
            'records' => WeatherSearch::where('user_id', $this->userId())->latest()->take(8)->get(),
            'result' => session('weather_result'),
        ]);
    }

    public function storeWeather(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'location_name' => ['required', 'string', 'max:191'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'forecast_date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:'.now()->addDays(5)->toDateString()],
        ]);

        try {
            $data = $this->withLocationAndWeather($data);
        } catch (RuntimeException $exception) {
            return back()->withInput()->withErrors(['location_name' => $exception->getMessage()]);
        }
        $weatherFields = collect($data)->only([
            'weather_data_id',
            'temperature',
            'humidity',
            'rainfall',
            'wind_speed',
            'cloud_cover',
            'weather_condition',
            'air_quality_index',
            'air_quality_category',
            'dominant_pollutant',
        ])->all();

        $record = WeatherSearch::create($data + $weatherFields + [
            'user_id' => $this->userId(),
            'farming_advice' => $this->engine->weatherAdvice($data),
        ]);

        return back()->with('weather_result', $record->fresh());
    }

    public function lookupWeather(Request $request): JsonResponse
    {
        $data = $request->validate([
            'location_name' => ['required', 'string', 'max:191'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'forecast_date' => ['nullable', 'date', 'after_or_equal:today', 'before_or_equal:'.now()->addDays(5)->toDateString()],
        ]);

        $data = $this->withLocationAndWeather($data);

        return response()->json(collect($data)->only([
            'weather_data_id',
            'location_name',
            'latitude',
            'longitude',
            'temperature',
            'humidity',
            'rainfall',
            'wind_speed',
            'cloud_cover',
            'weather_condition',
            'air_quality_index',
            'air_quality_category',
            'dominant_pollutant',
        ]));
    }

    public function reverseLocation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $location = $this->locations->reverseGeocode(
            (float) $data['latitude'],
            (float) $data['longitude']
        );

        if (! $location) {
            return response()->json([
                'message' => 'Your coordinates were found, but the nearby place name is temporarily unavailable.',
            ], 503);
        }

        return response()->json($location);
    }

    private function withLocationAndWeather(array $data): array
    {
        if (empty($data['latitude']) || empty($data['longitude'])) {
            $location = $this->locations->geocode($data['location_name']);

            if ($location) {
                $data['location_name'] = $location['name'];
                $data['latitude'] = $location['latitude'];
                $data['longitude'] = $location['longitude'];
            } else {
                throw ValidationException::withMessages([
                    'location_name' => 'Location was not found. Choose live location or enter a city, village, or district.',
                ]);
            }
        } elseif (str_starts_with(strtolower((string) ($data['location_name'] ?? '')), 'current location')) {
            $location = $this->locations->reverseGeocode(
                (float) $data['latitude'],
                (float) $data['longitude']
            );

            if ($location) {
                $data['location_name'] = $location['name'];
            }
        }

        if (! empty($data['latitude']) && ! empty($data['longitude'])) {
            $forecastDate = $data['forecast_date'] ?? now()->toDateString();
            $weather = $this->weather->forecast((float) $data['latitude'], (float) $data['longitude'], $forecastDate);
            $airQuality = $this->airQuality->current((float) $data['latitude'], (float) $data['longitude']);

            foreach (['temperature', 'humidity', 'rainfall', 'wind_speed', 'cloud_cover', 'weather_condition'] as $field) {
                $data[$field] = $data[$field] ?? $weather[$field] ?? null;
            }

            foreach (['air_quality_index', 'air_quality_category', 'dominant_pollutant'] as $field) {
                $data[$field] = $airQuality[$field] ?? null;
            }

            $weatherData = WeatherData::create([
                'user_id' => $this->userId(),
                'location_name' => $data['location_name'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ] + $weather + $airQuality);

            $data['weather_data_id'] = $weatherData->getKey();
        }

        return $data;
    }

    private function withSoilProfile(array $data): array
    {
        if (empty($data['soil_profile_id'])) {
            $data['soil_snapshot'] = collect($data)->only([
                'soil_type',
                'ph_value',
                'nitrogen_level',
                'phosphorus_level',
                'potassium_level',
                'organic_carbon',
                'soil_moisture',
            ])->all();

            return $data;
        }

        $profile = SoilProfile::where('user_id', $this->userId())->findOrFail($data['soil_profile_id']);

        $data['soil_type'] = $profile->soil_type;
        $data['ph_value'] = $profile->ph_value ?? $data['ph_value'] ?? null;
        $data['nitrogen_level'] = $profile->nitrogen_level ?? $data['nitrogen_level'] ?? null;
        $data['phosphorus_level'] = $profile->phosphorus_level ?? $data['phosphorus_level'] ?? null;
        $data['potassium_level'] = $profile->potassium_level ?? $data['potassium_level'] ?? null;
        $data['nitrogen_value'] = $profile->nitrogen_value;
        $data['phosphorus_value'] = $profile->phosphorus_value;
        $data['potassium_value'] = $profile->potassium_value;
        $data['organic_carbon'] = $profile->organic_carbon;
        $data['soil_moisture'] = $profile->soil_moisture;
        $data['soil_snapshot'] = $profile->snapshot();

        if (isset($data['nitrogen_level']) && ! is_numeric($data['nitrogen_level'])) {
            $data['nitrogen_level'] = $this->levelToValue($data['nitrogen_level']);
        }

        if (isset($data['phosphorus_level']) && ! is_numeric($data['phosphorus_level'])) {
            $data['phosphorus_level'] = $this->levelToValue($data['phosphorus_level']);
        }

        if (isset($data['potassium_level']) && ! is_numeric($data['potassium_level'])) {
            $data['potassium_level'] = $this->levelToValue($data['potassium_level']);
        }

        return $data;
    }

    private function levelToValue(?string $level): float
    {
        return match ($level) {
            'Low' => 30.0,
            'High' => 90.0,
            default => 60.0,
        };
    }

    private function cropPayload(array $data): array
    {
        return Arr::only($data, [
            'weather_data_id',
            'soil_profile_id',
            'soil_snapshot',
            'crop_name',
            'location_name',
            'latitude',
            'longitude',
            'soil_type',
            'temperature',
            'humidity',
            'rainfall',
            'ph_value',
            'nitrogen',
            'phosphorus',
            'potassium',
            'season',
        ]);
    }

    private function yieldPayload(array $data): array
    {
        return Arr::only($data, [
            'weather_data_id',
            'soil_profile_id',
            'soil_snapshot',
            'crop_name',
            'location_name',
            'latitude',
            'longitude',
            'land_area',
            'area_unit',
            'season',
            'soil_type',
            'irrigation_type',
            'previous_crop',
            'temperature',
            'humidity',
            'rainfall',
        ]);
    }

    private function fertilizerPayload(array $data): array
    {
        return Arr::only($data, [
            'weather_data_id',
            'crop_name',
            'location_name',
            'latitude',
            'longitude',
            'soil_type',
            'season',
            'growth_stage',
            'nitrogen_level',
            'phosphorus_level',
            'potassium_level',
            'ph_value',
            'current_problem',
        ]);
    }

    private function userId(): int|string|null
    {
        return Auth::id();
    }
}
