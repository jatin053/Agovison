<?php

namespace App\Repositories;

use App\Models\Auction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuctionRepository
{
    public function listing(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        return Auction::query()
            ->with(['crop.category', 'crop.images', 'farmer', 'winner'])
            ->withCount('bids')
            ->withMax('bids', 'amount')
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest('ends_at')
            ->paginate($perPage)
            ->withQueryString();
    }
}
