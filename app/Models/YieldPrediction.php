<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class YieldPrediction extends Model
{
    protected $fillable = [
        'user_id',
        'weather_data_id',
        'soil_profile_id',
        'soil_snapshot',
        'crop_name',
        'location_name',
        'latitude',
        'longitude',
        'land_area',
        'area_unit',
        'season',
        'soil_type',
        'irrigation_type',
        'previous_crop',
        'temperature',
        'humidity',
        'rainfall',
        'expected_yield',
        'yield_unit',
        'yield_status',
        'advice',
    ];

    protected $casts = [
        'soil_snapshot' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
