<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendationRequest;
use App\Http\Requests\SoilReportRequest;
use App\Models\Setting;
use App\Services\CropRecommendationService;
use App\Services\IrrigationInsightService;
use App\Services\MarketPriceService;
use App\Services\WeatherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IntelligenceController extends Controller
{
    public function __construct(
        private readonly CropRecommendationService $cropRecommendationService,
        private readonly IrrigationInsightService $irrigationInsightService,
        private readonly MarketPriceService $marketPriceService,
        private readonly WeatherService $weatherService,
    ) {
    }

    public function index(): View
    {
        $farmer = auth()->user();
        $latestWeather = $farmer->weatherLogs()->latest('logged_at')->first();

        if (! $latestWeather) {
            $latestWeather = $this->weatherService->fetchAndStore(
                Setting::query()->where('key', 'default_weather_city')->value('value') ?: ($farmer->city ?: 'Pune'),
                $farmer
            );
        }

        $soilReports = $farmer->soilReports()->with('crop')->take(6)->get();
        $latestSoilReport = $soilReports->first();
        $irrigationInsight = $latestSoilReport ? $this->irrigationInsightService->analyze($latestSoilReport) : null;

        return view('farmer.intelligence.index', [
            'soilReports' => $soilReports,
            'latestSoilReport' => $latestSoilReport,
            'irrigationInsight' => $irrigationInsight,
            'marketPrices' => $this->marketPriceService->highlights(),
            'latestWeather' => $latestWeather,
            'recommendation' => session('aiRecommendation'),
            'recommendationInput' => session('recommendationInput'),
            'crops' => $farmer->crops()->approved()->latest()->get(),
        ]);
    }

    public function recommend(RecommendationRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $weather = $this->weatherService->fetchWeather($validated['location']);

        $recommendation = $this->cropRecommendationService->recommend($validated, $weather);

        return redirect()
            ->route('farmer.intelligence.index')
            ->with('aiRecommendation', $recommendation)
            ->with('recommendationInput', $validated)
            ->with('success', 'AI crop recommendations refreshed for your farm profile.');
    }

    public function storeSoilReport(SoilReportRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $report = auth()->user()->soilReports()->create([
            ...$validated,
            'logged_at' => now(),
        ]);

        $insight = $this->irrigationInsightService->analyze($report);
        $report->update([
            'recommendations' => implode(' ', $insight['actions']),
            'meta' => ['status' => $insight['status'], 'efficiency_score' => $insight['efficiency_score']],
        ]);

        return redirect()
            ->route('farmer.intelligence.index')
            ->with('success', 'Soil intelligence report recorded successfully.');
    }
}
