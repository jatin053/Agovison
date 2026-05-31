<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request): RedirectResponse
    {
        Review::updateOrCreate([
            'buyer_id' => auth()->id(),
            'crop_id' => $request->input('crop_id'),
            'order_id' => $request->input('order_id'),
        ], [
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'review' => $request->input('review'),
            'is_approved' => true,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }
}
