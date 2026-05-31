<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        private readonly ActivityLogService $activityLogService,
    ) {
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return Collection<int, Order>
     */
    public function checkout(User $buyer, array $payload): Collection
    {
        $cartItems = Cart::query()
            ->with('crop.farmer')
            ->where('user_id', $buyer->id)
            ->get();

        if ($cartItems->isEmpty()) {
            throw new \RuntimeException('Your cart is empty.');
        }

        return DB::transaction(function () use ($buyer, $payload, $cartItems) {
            $orders = collect();

            $cartItems
                ->groupBy(fn (Cart $item) => $item->crop->user_id)
                ->each(function (Collection $items, $farmerId) use ($buyer, $payload, $orders) {
                    $subtotal = $items->sum(fn (Cart $item) => $item->line_total);
                    $tax = round($subtotal * 0.05, 2);
                    $shipping = $subtotal > 0 ? 75 : 0;
                    $discount = (float) ($payload['discount'] ?? 0);
                    $total = max($subtotal + $tax + $shipping - $discount, 0);
                    $paid = ($payload['payment_method'] ?? 'razorpay_demo') === 'razorpay_demo';

                    $order = Order::create([
                        'buyer_id' => $buyer->id,
                        'farmer_id' => (int) $farmerId,
                        'invoice_number' => 'INV-'.strtoupper(Str::random(8)),
                        'order_number' => 'AGR-'.strtoupper(Str::random(8)),
                        'status' => $paid ? 'processing' : 'pending',
                        'payment_status' => $paid ? 'paid' : 'pending',
                        'payment_method' => $payload['payment_method'] ?? 'razorpay_demo',
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'shipping_fee' => $shipping,
                        'discount' => $discount,
                        'total_amount' => $total,
                        'shipping_name' => $payload['shipping_name'],
                        'shipping_phone' => $payload['shipping_phone'] ?? null,
                        'shipping_email' => $payload['shipping_email'] ?? $buyer->email,
                        'shipping_address' => $payload['shipping_address'],
                        'shipping_city' => $payload['shipping_city'] ?? null,
                        'shipping_state' => $payload['shipping_state'] ?? null,
                        'shipping_country' => $payload['shipping_country'] ?? 'India',
                        'shipping_zipcode' => $payload['shipping_zipcode'] ?? null,
                        'notes' => $payload['notes'] ?? null,
                        'paid_at' => $paid ? now() : null,
                    ]);

                    $items->each(function (Cart $item) use ($order) {
                        $price = $item->crop->effective_price;

                        $order->items()->create([
                            'crop_id' => $item->crop_id,
                            'farmer_id' => $item->crop->user_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $price,
                            'total_price' => $price * $item->quantity,
                        ]);

                        $item->crop->decrement('stock', min($item->quantity, $item->crop->stock));
                    });

                    $order->payment()->create([
                        'user_id' => $buyer->id,
                        'gateway' => $payload['payment_method'] ?? 'razorpay_demo',
                        'transaction_id' => $payload['transaction_id'] ?? 'demo_'.Str::lower(Str::random(10)),
                        'amount' => $total,
                        'currency' => 'INR',
                        'status' => $paid ? 'paid' : 'pending',
                        'paid_at' => $paid ? now() : null,
                        'payload' => [
                            'gateway' => 'Razorpay Demo',
                            'note' => 'Demo payment completed locally.',
                        ],
                    ]);

                    event(new OrderPlaced($order));
                    $this->activityLogService->log('order.created', 'Order placed successfully.', $order, $buyer);
                    $orders->push($order->load(['items.crop', 'buyer', 'farmer', 'payment']));
                });

            $cartItems->each->delete();

            return $orders;
        });
    }
}
