<?php

namespace App\Models;

use App\Traits\HasActivityFeed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilReport extends Model
{
    /** @use HasFactory<\Database\Factories\SoilReportFactory> */
    use HasActivityFeed;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crop_id',
        'soil_type',
        'season',
        'ph',
        'nitrogen',
        'phosphorus',
        'potassium',
        'moisture_percentage',
        'water_level_percentage',
        'field_size',
        'recommendations',
        'logged_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'field_size' => 'decimal:2',
            'logged_at' => 'datetime',
            'meta' => 'array',
            'moisture_percentage' => 'decimal:2',
            'nitrogen' => 'decimal:2',
            'ph' => 'decimal:2',
            'phosphorus' => 'decimal:2',
            'potassium' => 'decimal:2',
            'water_level_percentage' => 'decimal:2',
        ];
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
