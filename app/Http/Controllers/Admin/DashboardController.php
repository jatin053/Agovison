<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Crop;
use App\Models\Order;
use App\Models\Post;
use App\Services\AnalyticsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(AnalyticsService $analyticsService): View
    {
        return view('admin.dashboard', [
            'analytics' => $analyticsService->admin(),
            'pendingCrops' => Crop::with(['farmer', 'category'])->where('status', 'pending')->latest()->take(6)->get(),
            'recentOrders' => Order::with(['buyer', 'farmer'])->latest()->take(6)->get(),
            'activeAuctions' => Auction::query()->with(['crop', 'farmer'])->withCount('bids')->withMax('bids', 'amount')->latest('ends_at')->take(4)->get(),
            'communityPulse' => Post::query()->with('user')->withCount(['likes', 'allComments'])->latest()->take(4)->get(),
        ]);
    }
}
