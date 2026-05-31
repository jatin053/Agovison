<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuctionRequest;
use App\Http\Requests\BidRequest;
use App\Models\Auction;
use App\Repositories\AuctionRepository;
use App\Services\ActivityLogService;
use App\Services\MarketPriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuctionController extends Controller
{
    public function __construct(
        private readonly ActivityLogService $activityLogService,
        private readonly MarketPriceService $marketPriceService,
    ) {
    }

    public function index(Request $request, AuctionRepository $auctionRepository): View
    {
        $user = auth()->user();

        return view('auctions.index', [
            'auctions' => $auctionRepository->listing($request->only('status')),
            'marketPrices' => $this->marketPriceService->highlights(4),
            'farmerCrops' => $user && $user->hasRole('Farmer')
                ? $user->crops()->approved()->latest()->get()
                : collect(),
        ]);
    }

    public function show(Auction $auction): View
    {
        return view('auctions.show', [
            'auction' => $auction->load([
                'crop.category',
                'crop.images',
                'farmer',
                'winner',
                'bids.user',
            ])->loadCount('bids'),
            'relatedAuctions' => Auction::query()
                ->where('id', '!=', $auction->id)
                ->with(['crop.images', 'farmer'])
                ->withCount('bids')
                ->withMax('bids', 'amount')
                ->take(3)
                ->get(),
        ]);
    }

    public function store(AuctionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $crop = auth()->user()->crops()->findOrFail($validated['crop_id']);
        $status = now()->between($validated['starts_at'], $validated['ends_at']) ? 'live' : 'scheduled';

        $auction = $crop->auctions()->create([
            'farmer_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'starting_price' => $validated['starting_price'],
            'reserve_price' => $validated['reserve_price'] ?? null,
            'bid_increment' => $validated['bid_increment'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
            'status' => $status,
        ]);

        $this->activityLogService->log('auction.created', 'Auction launched by farmer.', $auction, auth()->user());

        return redirect()->route('auctions.show', $auction)->with('success', 'Auction created successfully.');
    }

    public function bid(BidRequest $request, Auction $auction): RedirectResponse
    {
        abort_if($auction->farmer_id === auth()->id(), 403);

        if ($auction->ends_at->isPast()) {
            return back()->withErrors(['amount' => 'This auction has already ended.']);
        }

        if ($auction->starts_at->isFuture()) {
            return back()->withErrors(['amount' => 'Bidding will open once the auction goes live.']);
        }

        $minimumAmount = $auction->bids()->exists()
            ? $auction->current_price + (float) $auction->bid_increment
            : (float) $auction->starting_price;

        if ((float) $request->validated()['amount'] < $minimumAmount) {
            return back()->withErrors(['amount' => 'Your bid must be at least INR '.number_format($minimumAmount, 2).'.']);
        }

        $bid = $auction->bids()->create([
            'user_id' => auth()->id(),
            'amount' => $request->validated()['amount'],
            'note' => $request->validated()['note'] ?? null,
        ]);

        $auction->update([
            'status' => 'live',
            'winner_id' => auth()->id(),
        ]);

        $this->activityLogService->log('auction.bid', 'New auction bid placed.', $bid, auth()->user());

        return back()->with('success', 'Bid submitted successfully.');
    }
}
