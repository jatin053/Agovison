<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class WeatherSearch extends Model
{
    protected $fillable = [
        'user_id',
        'weather_data_id',
        'location_name',
        'forecast_date',
        'latitude',
        'longitude',
        'temperature',
        'humidity',
        'rainfall',
        'wind_speed',
        'cloud_cover',
        'weather_condition',
        'air_quality_index',
        'air_quality_category',
        'dominant_pollutant',
        'farming_advice',
    ];

    protected $casts = [
        'forecast_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
