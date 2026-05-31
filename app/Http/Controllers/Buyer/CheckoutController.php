<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $cartItems = auth()->user()->cartItems()->with('crop.images')->get();
        $subtotal = $cartItems->sum('line_total');

        return view('buyer.checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => round($subtotal * 0.05, 2),
            'shipping' => $subtotal > 0 ? 75 : 0,
        ]);
    }

    public function store(CheckoutRequest $request, OrderService $orderService): RedirectResponse
    {
        try {
            $orderService->checkout(auth()->user(), $request->validated());

            return redirect()->route('buyer.orders.index')->with('success', 'Order placed successfully.');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
