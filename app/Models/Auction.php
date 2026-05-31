<?php

namespace App\Models;

use App\Traits\HasActivityFeed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auction extends Model
{
    /** @use HasFactory<\Database\Factories\AuctionFactory> */
    use HasActivityFeed;
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'farmer_id',
        'winner_id',
        'title',
        'description',
        'starting_price',
        'reserve_price',
        'bid_increment',
        'starts_at',
        'ends_at',
        'status',
        'meta',
    ];

    protected $appends = [
        'current_price',
        'seconds_left',
    ];

    protected function casts(): array
    {
        return [
            'bid_increment' => 'decimal:2',
            'ends_at' => 'datetime',
            'meta' => 'array',
            'reserve_price' => 'decimal:2',
            'starting_price' => 'decimal:2',
            'starts_at' => 'datetime',
        ];
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->latest('amount');
    }

    public function scopeLive(Builder $query): Builder
    {
        return $query
            ->where('status', 'live')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function getCurrentPriceAttribute(): float
    {
        if ($this->bids_max_amount !== null) {
            return (float) $this->bids_max_amount;
        }

        if ($this->relationLoaded('bids') && $this->bids->isNotEmpty()) {
            return (float) $this->bids->max('amount');
        }

        return (float) $this->starting_price;
    }

    public function getSecondsLeftAttribute(): int
    {
        return max((int) now()->diffInSeconds($this->ends_at, false), 0);
    }
}
