<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpertQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['Admin', 'Farmer']) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'crop_id' => ['nullable', 'exists:crops,id'],
            'title' => ['required', 'string', 'max:255'],
            'question' => ['required', 'string', 'max:4000'],
            'priority' => ['nullable', Rule::in(['low', 'medium', 'high'])],
        ];
    }
}
