<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function store(Crop $crop): RedirectResponse
    {
        auth()->user()->favorites()->firstOrCreate([
            'crop_id' => $crop->id,
        ]);

        return back()->with('success', 'Crop added to your wishlist.');
    }

    public function destroy(Crop $crop): RedirectResponse
    {
        auth()->user()->favorites()->where('crop_id', $crop->id)->delete();

        return back()->with('success', 'Crop removed from your wishlist.');
    }
}
