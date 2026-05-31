<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AnalyticsService;
use App\Services\IrrigationInsightService;
use App\Services\MarketPriceService;
use App\Services\WeatherService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(
        AnalyticsService $analyticsService,
        WeatherService $weatherService,
        IrrigationInsightService $irrigationInsightService,
        MarketPriceService $marketPriceService,
    ): View
    {
        $user = auth()->user();
        $latestWeather = $user->weatherLogs()->latest()->first();

        if (! $latestWeather) {
            $latestWeather = $weatherService->fetchAndStore(
                Setting::query()->where('key', 'default_weather_city')->value('value') ?: ($user->city ?: 'Pune'),
                $user
            );
        }

        $latestSoilReport = $user->soilReports()->latest('logged_at')->first();

        return view('farmer.dashboard', [
            'analytics' => $analyticsService->farmer($user),
            'latestWeather' => $latestWeather,
            'recentOrders' => $user->farmerOrders()->with('buyer')->latest()->take(6)->get(),
            'latestReports' => $user->diseaseReports()->latest()->take(5)->get(),
            'latestSoilReport' => $latestSoilReport,
            'irrigationInsight' => $latestSoilReport ? $irrigationInsightService->analyze($latestSoilReport) : null,
            'marketPrices' => $marketPriceService->highlights(4),
            'latestAuctions' => $user->auctions()->with('crop')->withCount('bids')->withMax('bids', 'amount')->take(3)->get(),
        ]);
    }
}
