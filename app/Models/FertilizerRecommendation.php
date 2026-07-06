<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class FertilizerRecommendation extends Model
{
    protected $fillable = [
        'user_id',
        'weather_data_id',
        'soil_profile_id',
        'soil_snapshot',
        'crop_name',
        'location',
        'location_name',
        'latitude',
        'longitude',
        'soil_type',
        'season',
        'growth_stage',
        'nitrogen_level',
        'phosphorus_level',
        'potassium_level',
        'nitrogen_value',
        'phosphorus_value',
        'potassium_value',
        'ph_value',
        'current_problem',
        'irrigation_type',
        'previous_fertilizer',
        'last_application_date',
        'organic_preference',
        'notes',
        'temperature',
        'humidity',
        'rainfall',
        'weather_condition',
        'recommended_fertilizer_id',
        'recommended_fertilizer_name',
        'confidence',
        'recommended_fertilizer',
        'dosage_advice',
        'application_timing',
        'general_guidance',
        'reason',
        'warnings',
        'alternatives',
        'recommendation_source',
        'status',
        'admin_reviewed',
        'admin_note',
        'caution',
    ];

    protected $casts = [
        'soil_snapshot' => 'array',
        'reason' => 'array',
        'warnings' => 'array',
        'alternatives' => 'array',
        'admin_reviewed' => 'boolean',
        'last_application_date' => 'date',
        'confidence' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function soilProfile(): BelongsTo
    {
        return $this->belongsTo(SoilProfile::class);
    }

    public function fertilizer(): BelongsTo
    {
        return $this->belongsTo(Fertilizer::class, 'recommended_fertilizer_id');
    }
}
