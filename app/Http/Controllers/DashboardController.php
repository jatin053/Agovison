<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use App\Models\Crop;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use App\Services\MarketPriceService;
use App\Services\WeatherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function landing(MarketPriceService $marketPriceService, WeatherService $weatherService): View
    {
        return view('welcome', [
            'categories' => Category::active()->take(6)->get(),
            'featuredCrops' => Crop::approved()->with(['category', 'farmer', 'images'])->latest()->take(6)->get(),
            'communityHighlights' => Post::with('user')->withCount(['likes', 'allComments'])->latest()->take(3)->get(),
            'liveAuctions' => Auction::query()->with(['crop.images', 'farmer'])->withCount('bids')->withMax('bids', 'amount')->take(3)->get(),
            'marketPrices' => $marketPriceService->highlights(),
            'weatherSnapshot' => $weatherService->fetchWeather('Pune'),
            'stats' => [
                'farmers' => User::whereHas('roles', fn ($query) => $query->where('name', 'Farmer'))->count(),
                'buyers' => User::whereHas('roles', fn ($query) => $query->where('name', 'Buyer'))->count(),
                'crops' => Crop::approved()->count(),
                'orders' => Order::count(),
            ],
        ]);
    }

    public function redirect(Request $request): RedirectResponse
    {
        return redirect()->route($request->user()->dashboardRoute());
    }
}
