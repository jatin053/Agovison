<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Admin') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group' => ['required', 'string', 'max:120'],
            'key' => ['required', 'string', 'max:120', Rule::unique('settings', 'key')->ignore($this->route('setting'))],
            'label' => ['required', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:50'],
            'value' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }
}
