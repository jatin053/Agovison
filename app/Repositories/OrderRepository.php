<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository
{
    public function admin(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->applyFilters($this->baseQuery(), $filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function buyer(User $buyer, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->applyFilters($this->baseQuery()->where('buyer_id', $buyer->id), $filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function farmer(User $farmer, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->applyFilters($this->baseQuery()->where('farmer_id', $farmer->id), $filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    private function baseQuery(): Builder
    {
        return Order::query()->with(['buyer', 'farmer', 'items.crop', 'payment']);
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, static fn (Builder $builder, $status) => $builder->where('status', $status))
            ->when($filters['payment_status'] ?? null, static fn (Builder $builder, $status) => $builder->where('payment_status', $status))
            ->when($filters['search'] ?? null, static function (Builder $builder, string $search) {
                $builder->where(function (Builder $inner) use ($search) {
                    $inner->where('order_number', 'like', '%'.$search.'%')
                        ->orWhere('invoice_number', 'like', '%'.$search.'%')
                        ->orWhere('shipping_name', 'like', '%'.$search.'%');
                });
            });
    }
}
