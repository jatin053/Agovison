<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilProfile extends Model
{
    protected $fillable = [
        'user_id',
        'location',
        'latitude',
        'longitude',
        'soil_type',
        'crop_name',
        'soil_image_path',
        'confidence',
        'crop_advice',
        'analysis_source',
        'ph_value',
        'nitrogen_level',
        'phosphorus_level',
        'potassium_level',
        'nitrogen_value',
        'phosphorus_value',
        'potassium_value',
        'organic_carbon',
        'soil_moisture',
        'soil_temperature',
        'sand_percentage',
        'clay_percentage',
        'silt_percentage',
        'soil_test_date',
        'data_source',
        'api_provider',
        'api_response',
        'notes',
        'admin_note',
        'is_verified',
    ];

    protected $casts = [
        'api_response' => 'array',
        'is_verified' => 'boolean',
        'soil_test_date' => 'date',
        'ph_value' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'organic_carbon' => 'decimal:2',
        'soil_moisture' => 'decimal:2',
        'soil_temperature' => 'decimal:2',
        'sand_percentage' => 'decimal:2',
        'clay_percentage' => 'decimal:2',
        'silt_percentage' => 'decimal:2',
        'nitrogen_value' => 'decimal:2',
        'confidence' => 'decimal:2',
        'phosphorus_value' => 'decimal:2',
        'potassium_value' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function snapshot(): array
    {
        return [
            'soil_profile_id' => $this->getKey(),
            'location' => $this->location,
            'soil_type' => $this->soil_type,
            'ph_value' => $this->ph_value,
            'nitrogen_level' => $this->nitrogen_level,
            'phosphorus_level' => $this->phosphorus_level,
            'potassium_level' => $this->potassium_level,
            'nitrogen_value' => $this->nitrogen_value,
            'phosphorus_value' => $this->phosphorus_value,
            'potassium_value' => $this->potassium_value,
            'organic_carbon' => $this->organic_carbon,
            'soil_moisture' => $this->soil_moisture,
            'soil_temperature' => $this->soil_temperature,
            'data_source' => $this->data_source,
            'soil_test_date' => $this->soil_test_date?->toDateString(),
            'is_verified' => $this->is_verified,
        ];
    }
}
