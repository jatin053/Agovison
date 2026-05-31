<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Post;
use App\Services\ActivityLogService;
use App\Services\MarketPriceService;
use App\Services\WeatherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function __construct(
        private readonly WeatherService $weatherService,
        private readonly MarketPriceService $marketPriceService,
        private readonly ActivityLogService $activityLogService,
    ) {
    }

    public function about(): View
    {
        return view('public.about', [
            'marketPrices' => $this->marketPriceService->highlights(4),
            'stats' => [
                'advisory_sessions' => '18.4M',
                'connected_farms' => '120K+',
                'smart_devices' => '32K',
                'market_trades' => 'INR 48Cr',
            ],
        ]);
    }

    public function contact(): View
    {
        return view('public.contact', [
            'marketPrices' => $this->marketPriceService->highlights(4),
        ]);
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $this->activityLogService->log(
            'contact.request',
            'New contact request submitted from AgroVision AI website.',
            null,
            auth()->user(),
            $validated
        );

        return back()->with('success', 'Thanks, your request has been captured by the AgroVision AI team.');
    }

    public function weather(Request $request): View
    {
        $location = $request->string('location')->toString() ?: 'Pune';
        $weather = $this->weatherService->fetchWeather($location);

        return view('public.weather', [
            'location' => $location,
            'weather' => $weather,
            'marketPrices' => $this->marketPriceService->highlights(),
            'communityHighlights' => Post::query()->with('user')->latest()->take(3)->get(),
            'liveAuctions' => Auction::query()->with(['crop', 'farmer'])->withMax('bids', 'amount')->take(3)->get(),
        ]);
    }
}
