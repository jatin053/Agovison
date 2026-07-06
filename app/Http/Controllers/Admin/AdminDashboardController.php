<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\CropRecommendation;
use App\Models\DiseaseDetection;
use App\Models\FertilizerRecommendation;
use App\Models\SoilProfile;
use App\Models\User;
use App\Models\WeatherSearch;
use App\Models\YieldPrediction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminDashboardController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            [
                'label' => 'Total Users',
                'value' => User::count(),
                'detail' => 'All registered accounts',
                'tone' => 'green',
            ],
            [
                'label' => 'Admin Users',
                'value' => User::where('is_admin', true)->count(),
                'detail' => 'Accounts with panel access',
                'tone' => 'blue',
            ],
            [
                'label' => 'Verified Emails',
                'value' => User::whereNotNull('email_verified_at')->count(),
                'detail' => 'Verified user accounts',
                'tone' => 'purple',
            ],
            [
                'label' => 'Contact Messages',
                'value' => ContactMessage::count(),
                'detail' => 'Submitted from contact form',
                'tone' => 'amber',
            ],
            [
                'label' => 'Total Soil Profiles',
                'value' => SoilProfile::count(),
                'detail' => 'Saved soil information',
                'tone' => 'blue',
            ],
            [
                'label' => 'Verified Soil Reports',
                'value' => SoilProfile::where('is_verified', true)->count(),
                'detail' => 'Admin reviewed entries',
                'tone' => 'purple',
            ],
            [
                'label' => 'Farm Records',
                'value' => CropRecommendation::count() + YieldPrediction::count() + DiseaseDetection::count() + FertilizerRecommendation::count() + WeatherSearch::count() + SoilProfile::count(),
                'detail' => 'Saved feature activity',
                'tone' => 'green',
            ],
        ];

        $recentUsers = User::query()
            ->latest()
            ->take(8)
            ->get(['name', 'email', 'is_admin', 'created_at', 'email_verified_at']);

        $auditItems = [
            ['title' => 'Database connection', 'copy' => 'MySQL is configured for the `agro` database.', 'status' => 'Configured'],
            ['title' => 'Role security', 'copy' => 'Admin routes are protected by middleware.', 'status' => 'Protected'],
            ['title' => 'Seeded admin account', 'copy' => 'Default admin user is ready after seeding.', 'status' => 'Ready'],
        ];

        return view('admin.dashboard', compact('stats', 'recentUsers', 'auditItems'));
    }

    public function users(): View
    {
        $users = User::query()
            ->latest()
            ->get(['name', 'email', 'is_admin', 'created_at', 'email_verified_at']);

        $summary = [
            'total' => $users->count(),
            'admins' => $users->where('is_admin', true)->count(),
            'verified' => $users->whereNotNull('email_verified_at')->count(),
            'pending' => $users->whereNull('email_verified_at')->count(),
        ];

        return view('admin.users', compact('users', 'summary'));
    }

    public function contactMessages(): View
    {
        $messages = ContactMessage::query()
            ->latest()
            ->get();

        $summary = [
            'total' => $messages->count(),
            'today' => $messages->where('created_at', '>=', now()->startOfDay())->count(),
            'demo' => $messages->where('subject', 'Book a Demo')->count(),
            'support' => $messages->whereIn('subject', ['Product Support', 'Technical Help'])->count(),
        ];

        return view('admin.contact-messages', compact('messages', 'summary'));
    }

    public function reports(Request $request): View
    {
        $records = $this->allFarmRecords();

        if ($request->filled('type')) {
            $records = $records->where('type', $request->string('type')->toString());
        }

        if ($request->filled('user')) {
            $needle = strtolower($request->string('user')->toString());
            $records = $records->filter(fn ($record) => str_contains(strtolower($record['user']), $needle) || str_contains(strtolower($record['email']), $needle));
        }

        if ($request->filled('search')) {
            $needle = strtolower($request->string('search')->toString());
            $records = $records->filter(fn ($record) => str_contains(strtolower($record['crop'].' '.$record['location'].' '.$record['summary']), $needle));
        }

        $records = $records->sortByDesc('created_at')->values();

        $summary = [
            'total' => $records->count(),
            'crop' => CropRecommendation::count(),
            'yield' => YieldPrediction::count(),
            'disease' => DiseaseDetection::count(),
            'fertilizer' => FertilizerRecommendation::count(),
            'weather' => WeatherSearch::count(),
            'soil' => SoilProfile::count(),
        ];

        $featureTypes = [
            'crop' => 'Crop Recommendation',
            'yield' => 'Yield Prediction',
            'disease' => 'Disease Detection',
            'fertilizer' => 'Fertilizer Recommendation',
            'weather' => 'Weather Forecast',
            'soil' => 'Soil Information',
        ];

        return view('admin.reports', [
            'records' => $records,
            'summary' => $summary,
            'featureTypes' => $featureTypes,
            'filters' => $request->only(['type', 'user', 'search']),
        ]);
    }

    public function reportShow(string $type, int $id): View
    {
        $record = $this->reportRecord($type, $id);

        abort_if(! $record, 404);

        return view('admin.report-show', ['record' => $record]);
    }

    public function settings(): View
    {
        $system = [
            'Application Name' => config('app.name'),
            'Environment' => config('app.env'),
            'Database Connection' => config('database.default'),
            'MySQL Database' => config('database.connections.mysql.database'),
            'App URL' => config('app.url'),
        ];

        return view('admin.settings', compact('system'));
    }

    private function allFarmRecords(): Collection
    {
        return collect()
            ->merge(CropRecommendation::with('user')->latest()->get()->map(fn (CropRecommendation $item) => $this->recordRow(
                'crop',
                'Crop Recommendation',
                $item->id,
                $item->user,
                $item->crop_name ?: $item->recommended_crop,
                $item->location_name,
                $item->recommended_crop.' ('.$item->confidence_score.'%)',
                $this->cropInput($item),
                $this->cropResult($item),
                $item->created_at,
            )))
            ->merge(YieldPrediction::with('user')->latest()->get()->map(fn (YieldPrediction $item) => $this->recordRow(
                'yield',
                'Yield Prediction',
                $item->id,
                $item->user,
                $item->crop_name,
                $item->location_name,
                $item->expected_yield.' '.$item->yield_unit.' - '.$item->yield_status,
                $this->yieldInput($item),
                $this->yieldResult($item),
                $item->created_at,
            )))
            ->merge(DiseaseDetection::with('user')->latest()->get()->map(fn (DiseaseDetection $item) => $this->recordRow(
                'disease',
                'Disease Detection',
                $item->id,
                $item->user,
                $item->crop_name,
                $item->location ?: 'Image upload',
                ($item->disease_name ?: $item->detected_disease).' - '.$item->severity,
                $this->diseaseInput($item),
                $this->diseaseResult($item),
                $item->created_at,
            )))
            ->merge(FertilizerRecommendation::with('user')->latest()->get()->map(fn (FertilizerRecommendation $item) => $this->recordRow(
                'fertilizer',
                'Fertilizer Recommendation',
                $item->id,
                $item->user,
                $item->crop_name,
                $item->location ?: $item->location_name,
                $item->recommended_fertilizer_name ?: $item->recommended_fertilizer,
                $this->fertilizerInput($item),
                $this->fertilizerResult($item),
                $item->created_at,
            )))
            ->merge(SoilProfile::with('user')->latest()->get()->map(fn (SoilProfile $item) => $this->recordRow(
                'soil',
                'Soil Information',
                $item->id,
                $item->user,
                $item->soil_type,
                $item->location ?: 'No location',
                'pH '.($item->ph_value ?: 'N/A').' | NPK '.($item->nitrogen_level ?: 'N/A').'/'.($item->phosphorus_level ?: 'N/A').'/'.($item->potassium_level ?: 'N/A'),
                $this->soilInput($item),
                $this->soilResult($item),
                $item->created_at,
            )))
            ->merge(WeatherSearch::with('user')->latest()->get()->map(fn (WeatherSearch $item) => $this->recordRow(
                'weather',
                'Weather Forecast',
                $item->id,
                $item->user,
                'Weather',
                $item->location_name,
                ($item->temperature ?? 'N/A').' C, '.($item->weather_condition ?? 'Condition unavailable'),
                $this->weatherInput($item),
                $this->weatherResult($item),
                $item->created_at,
            )));
    }

    private function reportRecord(string $type, int $id): ?array
    {
        if ($type === 'crop') {
            $item = CropRecommendation::with('user')->find($id);

            return $item ? $this->recordRow('crop', 'Crop Recommendation', $item->id, $item->user, $item->crop_name ?: $item->recommended_crop, $item->location_name, $item->recommended_crop.' ('.$item->confidence_score.'%)', $this->cropInput($item), $this->cropResult($item), $item->created_at) : null;
        }

        if ($type === 'yield') {
            $item = YieldPrediction::with('user')->find($id);

            return $item ? $this->recordRow('yield', 'Yield Prediction', $item->id, $item->user, $item->crop_name, $item->location_name, $item->expected_yield.' '.$item->yield_unit.' - '.$item->yield_status, $this->yieldInput($item), $this->yieldResult($item), $item->created_at) : null;
        }

        if ($type === 'disease') {
            $item = DiseaseDetection::with('user')->find($id);

            return $item ? $this->recordRow('disease', 'Disease Detection', $item->id, $item->user, $item->crop_name, $item->location ?: 'Image upload', ($item->disease_name ?: $item->detected_disease).' - '.$item->severity, $this->diseaseInput($item), $this->diseaseResult($item), $item->created_at) : null;
        }

        if ($type === 'fertilizer') {
            $item = FertilizerRecommendation::with('user')->find($id);

            return $item ? $this->recordRow('fertilizer', 'Fertilizer Recommendation', $item->id, $item->user, $item->crop_name, $item->location ?: $item->location_name, $item->recommended_fertilizer_name ?: $item->recommended_fertilizer, $this->fertilizerInput($item), $this->fertilizerResult($item), $item->created_at) : null;
        }

        if ($type === 'soil') {
            $item = SoilProfile::with('user')->find($id);

            return $item ? $this->recordRow('soil', 'Soil Information', $item->id, $item->user, $item->soil_type, $item->location ?: 'No location', 'pH '.($item->ph_value ?: 'N/A').' | NPK '.($item->nitrogen_level ?: 'N/A').'/'.($item->phosphorus_level ?: 'N/A').'/'.($item->potassium_level ?: 'N/A'), $this->soilInput($item), $this->soilResult($item), $item->created_at) : null;
        }

        if ($type === 'weather') {
            $item = WeatherSearch::with('user')->find($id);

            return $item ? $this->recordRow('weather', 'Weather Forecast', $item->id, $item->user, 'Weather', $item->location_name, ($item->temperature ?? 'N/A').' C, '.($item->weather_condition ?? 'Condition unavailable'), $this->weatherInput($item), $this->weatherResult($item), $item->created_at) : null;
        }

        return null;
    }

    private function recordRow(string $type, string $label, int $id, ?User $user, ?string $crop, ?string $location, ?string $summary, array $input, array $result, mixed $createdAt): array
    {
        return [
            'id' => $id,
            'type' => $type,
            'type_label' => $label,
            'user' => $user?->name ?? 'Deleted user',
            'email' => $user?->email ?? 'N/A',
            'crop' => $crop ?: 'N/A',
            'location' => $location ?: 'N/A',
            'summary' => $summary ?: 'N/A',
            'input' => $input,
            'result' => $result,
            'date' => $createdAt?->format('M d, Y'),
            'created_at' => $createdAt,
        ];
    }

    private function cropInput(CropRecommendation $item): array
    {
        return [
            'Crop entered' => $item->crop_name ?: 'Optional field empty',
            'Location' => $item->location_name,
            'Latitude / Longitude' => $this->coordinates($item->latitude, $item->longitude),
            'Soil type' => $item->soil_type,
            'Temperature' => $this->unit($item->temperature, '°C'),
            'Humidity' => $this->unit($item->humidity, '%'),
            'Rainfall' => $this->unit($item->rainfall, 'mm'),
            'pH value' => $item->ph_value,
            'Nitrogen' => $item->nitrogen,
            'Phosphorus' => $item->phosphorus,
            'Potassium' => $item->potassium,
            'Season' => $item->season,
        ];
    }

    private function cropResult(CropRecommendation $item): array
    {
        return [
            'Recommended crop' => $item->recommended_crop,
            'Confidence score' => $this->unit($item->confidence_score, '%'),
            'Reason' => $item->reason,
            'Farming advice' => $item->farming_advice,
        ];
    }

    private function yieldInput(YieldPrediction $item): array
    {
        return [
            'Crop name' => $item->crop_name,
            'Location' => $item->location_name,
            'Latitude / Longitude' => $this->coordinates($item->latitude, $item->longitude),
            'Land area' => trim($item->land_area.' '.$item->area_unit),
            'Season' => $item->season,
            'Soil type' => $item->soil_type,
            'Irrigation type' => $item->irrigation_type,
            'Previous crop' => $item->previous_crop ?: 'Not provided',
            'Temperature' => $this->unit($item->temperature, '°C'),
            'Humidity' => $this->unit($item->humidity, '%'),
            'Rainfall' => $this->unit($item->rainfall, 'mm'),
            'Saved soil snapshot' => $this->compactJson($item->soil_snapshot),
        ];
    }

    private function yieldResult(YieldPrediction $item): array
    {
        return [
            'Expected yield' => trim($item->expected_yield.' '.$item->yield_unit),
            'Yield status' => $item->yield_status,
            'Advice' => $item->advice,
        ];
    }

    private function diseaseInput(DiseaseDetection $item): array
    {
        return [
            'Crop name' => $item->crop_name,
            'Uploaded image' => $item->image_path ?: $item->leaf_image_path,
            'Affected part' => $item->affected_part ?: $item->plant_part,
            'Symptoms' => $item->symptoms ?: $item->visible_symptom,
            'Symptom notes' => $item->symptom_notes,
            'Location' => $item->location ?: 'Not provided',
            'Crop age' => $item->crop_age,
            'Symptoms started' => $item->symptom_started,
            'Field affected' => $this->unit($item->field_affected, '%'),
            'Recent fertilizer' => $item->fertilizer_used,
            'Recent pesticide' => $item->pesticide_used,
        ];
    }

    private function diseaseResult(DiseaseDetection $item): array
    {
        return [
            'Detected disease' => $item->disease_name ?: $item->detected_disease,
            'Severity' => $item->severity,
            'Confidence score' => $this->unit($item->confidence ?: $item->confidence_score, '%'),
            'Status' => $item->status,
            'Possible cause' => $item->possible_cause,
            'Treatment suggestion' => $item->treatment ?: $item->treatment_suggestion,
            'Prevention' => $item->prevention,
            'Suggested products' => $this->productList($item->productRecommendations()),
            'Analysis source' => $item->analysis_source,
        ];
    }

    private function fertilizerInput(FertilizerRecommendation $item): array
    {
        return [
            'Crop name' => $item->crop_name,
            'Location' => $item->location ?: $item->location_name,
            'Latitude / Longitude' => $this->coordinates($item->latitude, $item->longitude),
            'Season' => $item->season,
            'Soil type' => $item->soil_type,
            'Growth stage' => $item->growth_stage,
            'Nitrogen level / value' => $this->levelValue($item->nitrogen_level, $item->nitrogen_value),
            'Phosphorus level / value' => $this->levelValue($item->phosphorus_level, $item->phosphorus_value),
            'Potassium level / value' => $this->levelValue($item->potassium_level, $item->potassium_value),
            'pH value' => $item->ph_value,
            'Current problem' => $item->current_problem,
            'Irrigation type' => $item->irrigation_type,
            'Previous fertilizer' => $item->previous_fertilizer,
            'Last application date' => $item->last_application_date?->format('M d, Y'),
            'Organic preference' => $item->organic_preference,
            'Notes' => $item->notes,
            'Weather used for timing' => $item->weather_condition,
            'Saved soil snapshot' => $this->compactJson($item->soil_snapshot),
        ];
    }

    private function fertilizerResult(FertilizerRecommendation $item): array
    {
        return [
            'Recommended fertilizer' => $item->recommended_fertilizer_name ?: $item->recommended_fertilizer,
            'Confidence' => $this->unit($item->confidence, '%'),
            'Status' => $item->status,
            'Dosage advice' => $item->dosage_advice,
            'Application timing' => $item->application_timing,
            'Reason' => $this->compactJson($item->reason),
            'General guidance' => $item->general_guidance,
            'Warnings / caution' => $this->compactJson($item->warnings) ?: $item->caution,
            'Alternatives' => $this->compactJson($item->alternatives),
            'Recommendation source' => $item->recommendation_source,
        ];
    }

    private function weatherInput(WeatherSearch $item): array
    {
        return [
            'Location searched' => $item->location_name,
            'Latitude / Longitude' => $this->coordinates($item->latitude, $item->longitude),
        ];
    }

    private function weatherResult(WeatherSearch $item): array
    {
        return [
            'Temperature' => $this->unit($item->temperature, '°C'),
            'Humidity' => $this->unit($item->humidity, '%'),
            'Rainfall' => $this->unit($item->rainfall, 'mm'),
            'Wind speed' => $this->unit($item->wind_speed, 'km/h'),
            'Cloud cover' => $this->unit($item->cloud_cover, '%'),
            'Weather condition' => $item->weather_condition,
            'Air quality index' => $item->air_quality_index,
            'Air quality category' => $item->air_quality_category,
            'Dominant pollutant' => $item->dominant_pollutant,
            'Farming advice' => $item->farming_advice,
        ];
    }

    private function soilInput(SoilProfile $item): array
    {
        return [
            'Location' => $item->location ?: 'Not provided',
            'Latitude / Longitude' => $this->coordinates($item->latitude, $item->longitude),
            'Soil type' => $item->soil_type,
            'pH value' => $item->ph_value,
            'Nitrogen level / value' => $this->levelValue($item->nitrogen_level, $item->nitrogen_value),
            'Phosphorus level / value' => $this->levelValue($item->phosphorus_level, $item->phosphorus_value),
            'Potassium level / value' => $this->levelValue($item->potassium_level, $item->potassium_value),
            'Organic carbon' => $item->organic_carbon,
            'Soil moisture' => $item->soil_moisture,
            'Soil temperature' => $item->soil_temperature,
            'Sand / clay / silt' => implode(' / ', array_filter([$item->sand_percentage, $item->clay_percentage, $item->silt_percentage], fn (mixed $value): bool => filled($value))) ?: 'Not provided',
            'Soil test date' => $item->soil_test_date?->format('M d, Y'),
            'Notes' => $item->notes,
        ];
    }

    private function soilResult(SoilProfile $item): array
    {
        return [
            'Saved profile result' => 'Soil profile saved for dashboard recommendations.',
            'Data source' => $item->data_source,
            'API provider' => $item->api_provider ?: 'Manual entry',
            'Admin verified' => $item->is_verified ? 'Yes' : 'No',
            'Admin note' => $item->admin_note,
        ];
    }

    private function unit(mixed $value, string $unit): ?string
    {
        return filled($value) ? trim($value.' '.$unit) : null;
    }

    private function coordinates(mixed $latitude, mixed $longitude): string
    {
        return filled($latitude) && filled($longitude) ? $latitude.', '.$longitude : 'Not available';
    }

    private function levelValue(mixed $level, mixed $value): string
    {
        return implode(' / ', array_filter([$level, filled($value) ? (string) $value : null], fn (mixed $part): bool => filled($part))) ?: 'Not provided';
    }

    private function compactJson(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (is_array($value)) {
            return collect($value)->map(function (mixed $item, mixed $key): string {
                if (is_array($item)) {
                    return is_string($key) ? $key.': '.json_encode($item) : json_encode($item);
                }

                return is_string($key) ? $key.': '.$item : $item;
            })->filter()->implode(' | ');
        }

        return (string) $value;
    }

    private function productList(array $products): string
    {
        return collect($products)
            ->map(fn (array $product): string => ($product['name'] ?? 'Product').' - '.($product['type'] ?? 'Suggestion'))
            ->implode(' | ');
    }
}
