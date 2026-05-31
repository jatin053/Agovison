<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Crop;
use App\Repositories\CropRepository;
use App\Services\MarketPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(Request $request, CropRepository $cropRepository, MarketPriceService $marketPriceService): View|JsonResponse
    {
        $filters = $request->only(['search', 'category', 'min_price', 'max_price', 'sort']);
        $categories = Category::active()
            ->withCount(['crops as approved_crops_count' => fn ($query) => $query->approved()])
            ->get();
        $crops = $cropRepository->approved($filters, 9);
        $fallbackCrops = Crop::query()
            ->approved()
            ->with(['category', 'farmer', 'images'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->whereKeyNot($crops->getCollection()->pluck('id'))
            ->latest()
            ->take(3)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('buyer.marketplace.partials.grid', compact('crops', 'fallbackCrops'))->render(),
                'pagination' => $crops->links()->toHtml(),
            ]);
        }

        $spotlightCrops = Crop::query()
            ->approved()
            ->with(['category', 'farmer', 'images'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        if ($spotlightCrops->isEmpty()) {
            $spotlightCrops = Crop::query()
                ->approved()
                ->with(['category', 'farmer', 'images'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->latest()
                ->take(3)
                ->get();
        }

        $catalogStats = [
            'listings' => Crop::query()->approved()->count(),
            'growers' => Crop::query()->approved()->distinct()->count('user_id'),
            'categories' => $categories->count(),
            'organic' => Crop::query()->approved()->where('organic', true)->count(),
        ];

        $hasActiveFilters = collect($filters)
            ->reject(fn ($value, $key) => $key === 'sort' && ($value === null || $value === '' || $value === 'latest'))
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->isNotEmpty();

        return view('buyer.marketplace.index', [
            'categories' => $categories,
            'crops' => $crops,
            'filters' => $filters,
            'marketPrices' => $marketPriceService->highlights(4),
            'catalogStats' => $catalogStats,
            'spotlightCrops' => $spotlightCrops,
            'fallbackCrops' => $fallbackCrops,
            'hasActiveFilters' => $hasActiveFilters,
            'selectedCategory' => $categories->firstWhere('id', (int) ($request->input('category') ?? 0)),
            'searchSuggestions' => ['Tomatoes', 'Onions', 'Potatoes', 'Chilli', 'Organic', 'Fresh harvest'],
        ]);
    }

    public function show(Crop $crop): View
    {
        abort_unless($crop->status === 'approved' || auth()->user()?->can('view', $crop), 404);

        $crop->increment('views');

        return view('buyer.marketplace.show', [
            'crop' => $crop->load(['category', 'farmer', 'images', 'reviews.buyer']),
            'relatedCrops' => Crop::approved()
                ->where('category_id', $crop->category_id)
                ->where('id', '!=', $crop->id)
                ->with(['images', 'farmer'])
                ->take(4)
                ->get(),
        ]);
    }
}
