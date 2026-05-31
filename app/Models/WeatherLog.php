<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherLog extends Model
{
    /** @use HasFactory<\Database\Factories\WeatherLogFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'temperature',
        'humidity',
        'rain_prediction',
        'wind_speed',
        'condition',
        'logged_at',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'logged_at' => 'datetime',
            'payload' => 'array',
            'temperature' => 'decimal:2',
            'humidity' => 'decimal:2',
            'rain_prediction' => 'decimal:2',
            'wind_speed' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
