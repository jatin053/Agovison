<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Crop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = auth()->user()->cartItems()->with('crop.images')->get();

        return view('buyer.cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $cartItems->sum('line_total'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'crop_id' => ['required', 'exists:crops,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $crop = Crop::approved()->findOrFail($validated['crop_id']);
        $item = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'crop_id' => $crop->id,
        ]);

        $item->quantity = $item->exists ? $item->quantity + $validated['quantity'] : $validated['quantity'];
        $item->unit_price = $crop->effective_price;
        $item->save();

        return back()->with('success', 'Item added to cart successfully.');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cart quantity updated successfully.');
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === auth()->id(), 403);
        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
