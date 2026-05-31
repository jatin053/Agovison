<?php

namespace App\Services;

use App\Models\Crop;

class MarketPriceService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function highlights(int $limit = 6): array
    {
        $crops = Crop::approved()->with('category')->take($limit)->get();

        if ($crops->isEmpty()) {
            return [
                $this->buildCard('Tomato', 'Pune Mandi', 1420, 'kg', 3.8),
                $this->buildCard('Onion', 'Nashik Mandi', 1280, 'kg', -2.4),
                $this->buildCard('Potato', 'Indore Mandi', 1165, 'kg', 1.9),
                $this->buildCard('Chilli', 'Nagpur Mandi', 2140, 'kg', 5.6),
            ];
        }

        return $crops->map(function (Crop $crop) {
            $seed = abs(crc32($crop->title.$crop->location));
            $change = round((($seed % 120) - 60) / 10, 1);

            return $this->buildCard(
                $crop->title,
                $crop->location ?: 'Smart Mandi',
                round((float) $crop->effective_price * 10, 2),
                $crop->unit,
                $change
            );
        })->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function buildCard(string $crop, string $market, float $price, string $unit, float $change): array
    {
        $base = abs(crc32($crop.$market));
        $series = collect(range(1, 7))
            ->map(fn (int $offset) => max(10, round($price + (($base + $offset * 13) % 160) - 80, 2)))
            ->all();

        return [
            'crop' => $crop,
            'market' => $market,
            'price' => $price,
            'unit' => $unit,
            'change' => $change,
            'trend' => $change >= 0 ? 'up' : 'down',
            'series' => $series,
        ];
    }
}
