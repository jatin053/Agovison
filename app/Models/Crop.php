<?php

namespace App\Models;

use App\Traits\HasActivityFeed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crop extends Model
{
    /** @use HasFactory<\Database\Factories\CropFactory> */
    use HasActivityFeed;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'approved_by',
        'title',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'sale_price',
        'stock',
        'unit',
        'location',
        'harvest_date',
        'organic',
        'is_featured',
        'views',
        'status',
        'approved_at',
        'meta',
    ];

    protected $appends = [
        'effective_price',
        'primary_image_url',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'harvest_date' => 'date',
            'is_featured' => 'boolean',
            'meta' => 'array',
            'organic' => 'boolean',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CropImage::class)->orderBy('sort_order');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function diseaseReports(): HasMany
    {
        return $this->hasMany(DiseaseReport::class);
    }

    public function soilReports(): HasMany
    {
        return $this->hasMany(SoilReport::class)->latest('logged_at');
    }

    public function expertQuestions(): HasMany
    {
        return $this->hasMany(ExpertQuestion::class);
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class)->latest('ends_at');
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->sale_price ?: $this->price);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $remoteImage = data_get($this->meta, 'hero_image');

        if (is_string($remoteImage) && $remoteImage !== '') {
            return $remoteImage;
        }

        $image = $this->images->firstWhere('is_primary', true) ?? $this->images->first();

        return $image?->image_path
            ? asset('storage/'.$image->image_path)
            : asset('assets/images/crop-placeholder.svg');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, static function (Builder $builder, string $search) {
                $builder->where(function (Builder $inner) use ($search) {
                    $inner->where('title', 'like', '%'.$search.'%')
                        ->orWhere('short_description', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%')
                        ->orWhere('location', 'like', '%'.$search.'%')
                        ->orWhereHas('category', static fn (Builder $category) => $category->where('name', 'like', '%'.$search.'%'))
                        ->orWhereHas('farmer', static fn (Builder $farmer) => $farmer->where('name', 'like', '%'.$search.'%'));
                });
            })
            ->when($filters['category'] ?? null, static fn (Builder $builder, $category) => $builder->where('category_id', $category))
            ->when($filters['min_price'] ?? null, static fn (Builder $builder, $price) => $builder->where('price', '>=', $price))
            ->when($filters['max_price'] ?? null, static fn (Builder $builder, $price) => $builder->where('price', '<=', $price))
            ->when($filters['status'] ?? null, static fn (Builder $builder, $status) => $builder->where('status', $status));
    }
}
