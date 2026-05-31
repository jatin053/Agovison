<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\ExpertAnswer;
use App\Models\ExpertQuestion;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buyers = User::role('Buyer')->get();
        $experts = User::role('Expert')->get();
        $crops = Crop::approved()->with('farmer')->get();

        if ($buyers->isEmpty() || $crops->isEmpty()) {
            return;
        }

        foreach ($buyers as $buyer) {
            $selectedCrop = $crops->random();
            $subtotal = $selectedCrop->effective_price * 2;
            $invoiceNumber = 'INV-SEED-'.str_pad((string) $buyer->id, 4, '0', STR_PAD_LEFT);
            $orderNumber = 'AGR-SEED-'.str_pad((string) $buyer->id, 4, '0', STR_PAD_LEFT);

            $order = Order::updateOrCreate([
                'invoice_number' => $invoiceNumber,
            ], [
                'buyer_id' => $buyer->id,
                'farmer_id' => $selectedCrop->user_id,
                'order_number' => $orderNumber,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'razorpay_demo',
                'subtotal' => $subtotal,
                'tax' => round($subtotal * 0.05, 2),
                'shipping_fee' => 75,
                'discount' => 0,
                'total_amount' => round($subtotal * 1.05 + 75, 2),
                'shipping_name' => $buyer->name,
                'shipping_phone' => $buyer->phone,
                'shipping_email' => $buyer->email,
                'shipping_address' => $buyer->address ?? 'Demo Address',
                'shipping_city' => $buyer->city,
                'shipping_state' => $buyer->state,
                'shipping_country' => $buyer->country ?? 'India',
                'shipping_zipcode' => '411001',
                'paid_at' => now()->subDays(5),
                'delivered_at' => now()->subDay(),
            ]);

            $order->items()->updateOrCreate([
                'crop_id' => $selectedCrop->id,
            ], [
                'farmer_id' => $selectedCrop->user_id,
                'quantity' => 2,
                'unit_price' => $selectedCrop->effective_price,
                'total_price' => $subtotal,
            ]);

            $order->payment()->updateOrCreate([
                'order_id' => $order->id,
            ], [
                'user_id' => $buyer->id,
                'gateway' => 'razorpay_demo',
                'transaction_id' => 'seed_txn_'.$buyer->id,
                'amount' => $order->total_amount,
                'currency' => 'INR',
                'status' => 'paid',
                'paid_at' => now()->subDays(5),
                'payload' => ['seeded' => true],
            ]);

            Review::firstOrCreate([
                'buyer_id' => $buyer->id,
                'crop_id' => $selectedCrop->id,
                'order_id' => $order->id,
            ], [
                'rating' => fake()->numberBetween(4, 5),
                'title' => 'Reliable produce',
                'review' => fake()->sentence(),
                'is_approved' => true,
            ]);

            Favorite::firstOrCreate([
                'user_id' => $buyer->id,
                'crop_id' => $selectedCrop->id,
            ]);

            if ($experts->isNotEmpty()) {
                $question = ExpertQuestion::updateOrCreate([
                    'user_id' => $selectedCrop->user_id,
                    'crop_id' => $selectedCrop->id,
                    'title' => 'Need support for '.$selectedCrop->title,
                ], [
                    'expert_id' => $experts->random()->id,
                    'question' => fake()->paragraph(),
                    'priority' => 'medium',
                    'status' => 'answered',
                    'answered_at' => now()->subDay(),
                ]);

                ExpertAnswer::updateOrCreate([
                    'expert_question_id' => $question->id,
                ], [
                    'expert_id' => $question->expert_id,
                    'answer' => 'Maintain balanced irrigation, monitor pests weekly, and apply micronutrients after rain.',
                    'is_solution' => true,
                ]);
            }
        }
    }
}
