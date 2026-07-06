<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $table = 'weather_data';

    protected $fillable = [
        'user_id',
        'location_name',
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
        'air_quality_raw',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'air_quality_raw' => 'array',
    ];
}
