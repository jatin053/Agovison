<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FertilizerRule extends Model
{
    protected $fillable = [
        'crop_name',
        'soil_type',
        'season',
        'growth_stage',
        'nutrient_type',
        'nutrient_condition',
        'minimum_ph',
        'maximum_ph',
        'problem',
        'fertilizer_id',
        'priority',
        'reason',
        'general_guidance',
        'warning',
        'status',
    ];

    protected $casts = [
        'minimum_ph' => 'decimal:2',
        'maximum_ph' => 'decimal:2',
        'priority' => 'integer',
    ];

    public function fertilizer(): BelongsTo
    {
        return $this->belongsTo(Fertilizer::class);
    }
}
