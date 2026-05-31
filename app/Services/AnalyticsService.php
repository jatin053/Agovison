<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Crop;
use App\Models\ExpertAnswer;
use App\Models\ExpertQuestion;
use App\Models\Order;
use App\Models\Post;
use App\Models\SoilReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnalyticsService
{
    /**
     * @return array<string, mixed>
     */
    public function admin(): array
    {
        return [
            'totals' => [
                'users' => User::count(),
                'farmers' => User::whereHas('roles', fn ($query) => $query->where('name', 'Farmer'))->count(),
                'crops' => Crop::count(),
                'orders' => Order::count(),
                'revenue' => (float) Order::where('payment_status', 'paid')->sum('total_amount'),
                'live_auctions' => Auction::whereIn('status', ['live', 'scheduled'])->count(),
                'community_posts' => Post::count(),
            ],
            'monthly_sales' => $this->series(
                Order::where('payment_status', 'paid')
                    ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                    ->get(['created_at', 'total_amount']),
                'total_amount'
            ),
            'user_growth' => $this->series(
                User::where('created_at', '>=', now()->subMonths(5)->startOfMonth())->get(['created_at']),
                null
            ),
            'crop_sales' => Crop::query()
                ->withSum('orderItems', 'quantity')
                ->take(5)
                ->get()
                ->map(fn (Crop $crop) => [
                    'label' => $crop->title,
                    'value' => (int) ($crop->order_items_sum_quantity ?? 0),
                ])
                ->all(),
            'auction_activity' => $this->series(
                Auction::where('created_at', '>=', now()->subMonths(5)->startOfMonth())->get(['created_at']),
                null
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function farmer(User $farmer): array
    {
        $orders = Order::where('farmer_id', $farmer->id)->get();

        return [
            'totals' => [
                'crops' => $farmer->crops()->count(),
                'pending_crops' => $farmer->crops()->where('status', 'pending')->count(),
                'orders' => $orders->count(),
                'revenue' => (float) $orders->where('payment_status', 'paid')->sum('total_amount'),
                'auctions' => $farmer->auctions()->count(),
                'soil_reports' => SoilReport::where('user_id', $farmer->id)->count(),
            ],
            'sales' => $this->series($orders->where('created_at', '>=', now()->subMonths(5)->startOfMonth()), 'total_amount'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function buyer(User $buyer): array
    {
        return [
            'totals' => [
                'orders' => $buyer->buyerOrders()->count(),
                'spending' => (float) $buyer->buyerOrders()->where('payment_status', 'paid')->sum('total_amount'),
                'favorites' => $buyer->favorites()->count(),
                'cart_items' => $buyer->cartItems()->count(),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function expert(User $expert): array
    {
        return [
            'totals' => [
                'open_questions' => ExpertQuestion::where('status', 'open')->count(),
                'assigned_to_me' => ExpertQuestion::where('expert_id', $expert->id)->count(),
                'answers' => ExpertAnswer::where('expert_id', $expert->id)->count(),
            ],
        ];
    }

    /**
     * @param  Collection<int, mixed>  $records
     * @return array<string, array<int, int|float|string>>
     */
    private function series(Collection $records, ?string $amountKey): array
    {
        $months = collect(range(5, 0))
            ->map(fn (int $offset) => now()->subMonths($offset)->format('M'))
            ->values();

        $values = $months->map(function (string $monthLabel) use ($records, $amountKey) {
            $bucket = $records->filter(fn ($record) => Carbon::parse($record->created_at)->format('M') === $monthLabel);

            return $amountKey
                ? round((float) $bucket->sum($amountKey), 2)
                : $bucket->count();
        });

        return [
            'labels' => $months->all(),
            'values' => $values->all(),
        ];
    }
}
