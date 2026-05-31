<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public function adminListing(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->when($filters['search'] ?? null, static function (Builder $builder, string $search) {
                $builder->where(function (Builder $inner) use ($search) {
                    $inner->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%');
                });
            })
            ->when($filters['role'] ?? null, static fn (Builder $builder, string $role) => $builder->role($role))
            ->when($filters['status'] ?? null, static fn (Builder $builder, string $status) => $builder->where('status', $status))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
