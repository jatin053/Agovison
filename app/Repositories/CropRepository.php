<?php

namespace App\Repositories;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CropRepository
{
    public function approved(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->approved()
            ->filter($filters)
            ->orderBy($this->sortColumn($filters['sort'] ?? 'latest'), $this->sortDirection($filters['sort'] ?? 'latest'))
            ->paginate($perPage)
            ->withQueryString();
    }

    public function farmerInventory(User $farmer, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->where('user_id', $farmer->id)
            ->filter($filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function adminListing(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->filter($filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    private function baseQuery(): Builder
    {
        return Crop::query()
            ->with(['category', 'farmer', 'images'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');
    }

    private function sortColumn(string $sort): string
    {
        return match ($sort) {
            'price_asc', 'price_desc' => 'price',
            'popular' => 'views',
            default => 'created_at',
        };
    }

    private function sortDirection(string $sort): string
    {
        return $sort === 'price_asc' ? 'asc' : 'desc';
    }
}
