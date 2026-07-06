<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fertilizer extends Model
{
    protected $fillable = [
        'name',
        'fertilizer_type',
        'nutrient_n',
        'nutrient_p',
        'nutrient_k',
        'micronutrients',
        'suitable_crops',
        'suitable_soils',
        'suitable_growth_stages',
        'problems_addressed',
        'organic',
        'description',
        'application_guidance',
        'warnings',
        'status',
    ];

    protected $casts = [
        'micronutrients' => 'array',
        'suitable_crops' => 'array',
        'suitable_soils' => 'array',
        'suitable_growth_stages' => 'array',
        'problems_addressed' => 'array',
        'organic' => 'boolean',
        'nutrient_n' => 'decimal:2',
        'nutrient_p' => 'decimal:2',
        'nutrient_k' => 'decimal:2',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(FertilizerRule::class);
    }
}
