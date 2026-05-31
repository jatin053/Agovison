<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SoilReportRequest extends FormRequest
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
            'crop_id' => ['nullable', 'exists:crops,id'],
            'soil_type' => ['required', Rule::in(['loamy', 'clay', 'sandy', 'black'])],
            'season' => ['required', Rule::in(['kharif', 'rabi', 'zaid'])],
            'ph' => ['required', 'numeric', 'between:3,10'],
            'nitrogen' => ['nullable', 'numeric', 'min:0'],
            'phosphorus' => ['nullable', 'numeric', 'min:0'],
            'potassium' => ['nullable', 'numeric', 'min:0'],
            'moisture_percentage' => ['required', 'numeric', 'between:0,100'],
            'water_level_percentage' => ['required', 'numeric', 'between:0,100'],
            'field_size' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
