<?php

namespace App\Http\Controllers;

use App\Models\CropRecommendation;
use App\Models\DiseaseDetection;
use App\Models\FertilizerRecommendation;
use App\Models\SoilProfile;
use App\Models\WeatherSearch;
use App\Models\YieldPrediction;
use App\Services\SimplePdfReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class FarmReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = $this->filteredReports($request);

        return view('dashboard_ui.reports', [
            'reports' => $reports,
            'featureTypes' => $this->featureTypes(),
            'filters' => $request->only(['type', 'crop', 'location', 'from', 'to']),
        ]);
    }

    public function csv(Request $request): Response
    {
        $rows = $this->filteredReports($request);
        $csv = "Feature,Crop,Location,Result,Date\n";

        foreach ($rows as $row) {
            $csv .= collect([$row['type_label'], $row['crop'], $row['location'], $row['summary'], $row['date']])
                ->map(fn ($value) => '"'.str_replace('"', '""', (string) $value).'"')
                ->implode(',')."\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="farm-reports.csv"',
        ]);
    }

    public function pdf(Request $request, SimplePdfReport $pdf): Response
    {
        $lines = $this->filteredReports($request)->take(34)->map(
            fn ($row) => "{$row['date']} | {$row['type_label']} | {$row['crop']} | {$row['location']} | {$row['summary']}"
        )->all();

        return response($pdf->make('AgroVision Farm Reports', $lines), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="farm-reports.pdf"',
        ]);
    }

    private function filteredReports(Request $request): Collection
    {
        $reports = $this->allReports();

        if ($request->filled('type')) {
            $reports = $reports->where('type', $request->string('type')->toString());
        }

        if ($request->filled('crop')) {
            $needle = strtolower($request->string('crop')->toString());
            $reports = $reports->filter(fn ($report) => str_contains(strtolower($report['crop']), $needle));
        }

        if ($request->filled('location')) {
            $needle = strtolower($request->string('location')->toString());
            $reports = $reports->filter(fn ($report) => str_contains(strtolower($report['location']), $needle));
        }

        if ($request->filled('from')) {
            $reports = $reports->filter(fn ($report) => $report['created_at']->toDateString() >= $request->date('from')->toDateString());
        }

        if ($request->filled('to')) {
            $reports = $reports->filter(fn ($report) => $report['created_at']->toDateString() <= $request->date('to')->toDateString());
        }

        return $reports->sortByDesc('created_at')->values();
    }

    private function allReports(): Collection
    {
        $userId = auth()->id();

        return collect()
            ->merge(CropRecommendation::where('user_id', $userId)->latest()->get()->map(fn ($item) => [
                'type' => 'crop',
                'type_label' => 'Crop Recommendation',
                'crop' => $item->crop_name ?: $item->recommended_crop,
                'location' => $item->location_name,
                'summary' => $item->recommended_crop.' ('.$item->confidence_score.'%)',
                'details' => $item->reason,
                'date' => $item->created_at->format('M d, Y'),
                'created_at' => $item->created_at,
            ]))
            ->merge(YieldPrediction::where('user_id', $userId)->latest()->get()->map(fn ($item) => [
                'type' => 'yield',
                'type_label' => 'Yield Prediction',
                'crop' => $item->crop_name,
                'location' => $item->location_name,
                'summary' => $item->expected_yield.' '.$item->yield_unit.' - '.$item->yield_status,
                'details' => $item->advice,
                'date' => $item->created_at->format('M d, Y'),
                'created_at' => $item->created_at,
            ]))
            ->merge(DiseaseDetection::where('user_id', $userId)->latest()->get()->map(fn ($item) => [
                'type' => 'disease',
                'type_label' => 'Disease Detection',
                'crop' => $item->crop_name,
                'location' => $item->location ?: 'Image upload',
                'summary' => ($item->disease_name ?: $item->detected_disease).' - '.$item->severity,
                'details' => $item->treatment ?: $item->treatment_suggestion,
                'date' => $item->created_at->format('M d, Y'),
                'created_at' => $item->created_at,
            ]))
            ->merge(SoilProfile::where('user_id', $userId)->latest()->get()->map(fn ($item) => [
                'type' => 'soil',
                'type_label' => 'Soil Information',
                'crop' => $item->soil_type,
                'location' => $item->location ?: 'No location',
                'summary' => 'pH '.($item->ph_value ?: 'N/A').' | NPK '.($item->nitrogen_level ?: 'N/A').'/'.($item->phosphorus_level ?: 'N/A').'/'.($item->potassium_level ?: 'N/A'),
                'details' => $item->data_source.($item->is_verified ? ' | Admin reviewed' : ''),
                'date' => $item->created_at->format('M d, Y'),
                'created_at' => $item->created_at,
            ]))
            ->merge(FertilizerRecommendation::where('user_id', $userId)->latest()->get()->map(fn ($item) => [
                'type' => 'fertilizer',
                'type_label' => 'Fertilizer Recommendation',
                'crop' => $item->crop_name,
                'location' => $item->location ?: $item->location_name,
                'summary' => $item->recommended_fertilizer_name ?: $item->recommended_fertilizer,
                'details' => is_array($item->reason) ? implode(' ', $item->reason) : $item->reason,
                'date' => $item->created_at->format('M d, Y'),
                'created_at' => $item->created_at,
            ]))
            ->merge(WeatherSearch::where('user_id', $userId)->latest()->get()->map(fn ($item) => [
                'type' => 'weather',
                'type_label' => 'Weather Forecast',
                'crop' => 'Weather',
                'location' => $item->location_name,
                'summary' => ($item->temperature ?? 'N/A').' C, '.($item->weather_condition ?? 'Condition unavailable'),
                'details' => $item->farming_advice,
                'date' => $item->created_at->format('M d, Y'),
                'created_at' => $item->created_at,
            ]));
    }

    private function featureTypes(): array
    {
        return [
            'crop' => 'Crop Recommendation',
            'yield' => 'Yield Prediction',
            'disease' => 'Disease Detection',
            'fertilizer' => 'Fertilizer Recommendation',
            'soil' => 'Soil Information',
            'weather' => 'Weather Forecast',
        ];
    }
}
