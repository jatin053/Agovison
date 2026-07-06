<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CropRecommendation extends Model
{
    protected $fillable = [
        'user_id',
        'weather_data_id',
        'crop_name',
        'location_name',
        'latitude',
        'longitude',
        'soil_type',
        'temperature',
        'humidity',
        'rainfall',
        'ph_value',
        'nitrogen',
        'phosphorus',
        'potassium',
        'season',
        'recommended_crop',
        'confidence_score',
        'reason',
        'farming_advice',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
