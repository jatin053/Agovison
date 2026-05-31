<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest
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
            'crop_id' => ['required', 'exists:crops,id'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:2500'],
            'starting_price' => ['required', 'numeric', 'min:1'],
            'reserve_price' => ['nullable', 'numeric', 'gte:starting_price'],
            'bid_increment' => ['required', 'numeric', 'min:10'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
        ];
    }
}
