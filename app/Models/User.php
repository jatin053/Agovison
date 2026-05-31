<?php

namespace App\Models;

use App\Traits\HasActivityFeed;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasActivityFeed;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'address',
        'city',
        'state',
        'country',
        'bio',
        'status',
        'is_blocked',
        'blocked_at',
        'last_seen_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'blocked_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'is_blocked' => 'boolean',
            'last_seen_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function crops(): HasMany
    {
        return $this->hasMany(Crop::class);
    }

    public function approvedCrops(): HasMany
    {
        return $this->hasMany(Crop::class, 'approved_by');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function buyerOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function farmerOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'farmer_id');
    }

    public function diseaseReports(): HasMany
    {
        return $this->hasMany(DiseaseReport::class);
    }

    public function expertQuestions(): HasMany
    {
        return $this->hasMany(ExpertQuestion::class);
    }

    public function expertResponses(): HasMany
    {
        return $this->hasMany(ExpertAnswer::class, 'expert_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class)->latest();
    }

    public function soilReports(): HasMany
    {
        return $this->hasMany(SoilReport::class)->latest('logged_at');
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class, 'farmer_id')->latest('ends_at');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->latest();
    }

    public function favoriteCrops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'favorites')->withTimestamps();
    }

    public function weatherLogs(): HasMany
    {
        return $this->hasMany(WeatherLog::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function notificationsFeed(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }

    public function dashboardRoute(): string
    {
        return match (true) {
            $this->hasRole('Admin') => 'admin.dashboard',
            $this->hasRole('Farmer') => 'farmer.dashboard',
            $this->hasRole('Expert') => 'expert.dashboard',
            default => 'buyer.marketplace.index',
        };
    }

    public function primaryRole(): string
    {
        return $this->roles->first()?->name ?? 'Buyer';
    }
}
