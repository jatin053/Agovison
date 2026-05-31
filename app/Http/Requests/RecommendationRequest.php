<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecommendationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Farmer');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'location' => ['required', 'string', 'max:120'],
            'soil_type' => ['required', Rule::in(['loamy', 'clay', 'sandy', 'black'])],
            'season' => ['required', Rule::in(['kharif', 'rabi', 'zaid'])],
            'water_level_percentage' => ['required', 'numeric', 'between:0,100'],
            'moisture_percentage' => ['nullable', 'numeric', 'between:0,100'],
        ];
    }
}
