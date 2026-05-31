<?php

namespace App\Services;

class CropRecommendationService
{
    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $weather
     * @return array<string, mixed>
     */
    public function recommend(array $payload, array $weather = []): array
    {
        $soilType = strtolower((string) $payload['soil_type']);
        $season = strtolower((string) $payload['season']);
        $waterLevel = (float) $payload['water_level_percentage'];
        $moisture = (float) ($payload['moisture_percentage'] ?? 0);

        $knowledgeBase = [
            'loamy' => [
                'kharif' => [
                    ['name' => 'Paddy', 'score' => 95, 'reason' => 'Loamy structure and monsoon conditions support strong establishment.'],
                    ['name' => 'Maize', 'score' => 88, 'reason' => 'Balanced drainage helps maximize vegetative growth.'],
                    ['name' => 'Soybean', 'score' => 82, 'reason' => 'Good moisture retention supports pod formation.'],
                ],
                'rabi' => [
                    ['name' => 'Wheat', 'score' => 94, 'reason' => 'Loamy soil supports even root development and grain filling.'],
                    ['name' => 'Mustard', 'score' => 86, 'reason' => 'Performs well with moderate winter moisture.'],
                    ['name' => 'Chickpea', 'score' => 82, 'reason' => 'Requires less standing water and thrives with stable structure.'],
                ],
            ],
            'clay' => [
                'kharif' => [
                    ['name' => 'Paddy', 'score' => 96, 'reason' => 'Clay holds water well, ideal for flooded rice systems.'],
                    ['name' => 'Sugarcane', 'score' => 84, 'reason' => 'High water retention supports long growth cycles.'],
                    ['name' => 'Jute', 'score' => 79, 'reason' => 'Moisture-rich conditions support fiber crops.'],
                ],
                'rabi' => [
                    ['name' => 'Wheat', 'score' => 83, 'reason' => 'Heavy soils can still perform well with timed irrigation.'],
                    ['name' => 'Pea', 'score' => 78, 'reason' => 'Cool season works if compaction is managed.'],
                    ['name' => 'Barley', 'score' => 75, 'reason' => 'Resilient under tighter soil conditions.'],
                ],
            ],
            'sandy' => [
                'kharif' => [
                    ['name' => 'Groundnut', 'score' => 92, 'reason' => 'Loose soil structure supports pod expansion.'],
                    ['name' => 'Bajra', 'score' => 90, 'reason' => 'Tolerates lower water-holding capacity very well.'],
                    ['name' => 'Sesame', 'score' => 84, 'reason' => 'Thrives in quick-draining warm fields.'],
                ],
                'rabi' => [
                    ['name' => 'Cumin', 'score' => 88, 'reason' => 'Dry, quick-draining conditions suit winter spice crops.'],
                    ['name' => 'Potato', 'score' => 80, 'reason' => 'Good tuber formation with controlled irrigation.'],
                    ['name' => 'Onion', 'score' => 78, 'reason' => 'Responds well when fertigation is precise.'],
                ],
            ],
            'black' => [
                'kharif' => [
                    ['name' => 'Cotton', 'score' => 95, 'reason' => 'Black cotton soil offers excellent moisture support.'],
                    ['name' => 'Soybean', 'score' => 89, 'reason' => 'Supports root anchoring and balanced moisture use.'],
                    ['name' => 'Tur', 'score' => 84, 'reason' => 'Performs well in deep, moisture-conserving profiles.'],
                ],
                'rabi' => [
                    ['name' => 'Wheat', 'score' => 84, 'reason' => 'Strong option if irrigation is scheduled carefully.'],
                    ['name' => 'Safflower', 'score' => 80, 'reason' => 'Deep soils help late-season oilseed performance.'],
                    ['name' => 'Gram', 'score' => 79, 'reason' => 'Residual moisture can support pulse yield.'],
                ],
            ],
        ];

        $candidates = $knowledgeBase[$soilType][$season] ?? [
            ['name' => 'Maize', 'score' => 82, 'reason' => 'Adaptive crop with good market flexibility.'],
            ['name' => 'Tomato', 'score' => 78, 'reason' => 'High-value option with strong advisory support.'],
            ['name' => 'Chilli', 'score' => 76, 'reason' => 'Profitable where irrigation is controlled.'],
        ];

        $waterAdjustment = match (true) {
            $waterLevel >= 75 => ['headline' => 'Water reserves are strong.', 'bonus' => 6, 'irrigation' => 'You can support water-intensive crops and maintain wider fertigation windows.'],
            $waterLevel >= 45 => ['headline' => 'Water availability is balanced.', 'bonus' => 2, 'irrigation' => 'Focus on drip scheduling and avoid midday irrigation losses.'],
            default => ['headline' => 'Water stress risk is elevated.', 'bonus' => -6, 'irrigation' => 'Prioritize drought-tolerant crops and shorter irrigation cycles.'],
        };

        $moistureLabel = match (true) {
            $moisture >= 70 => 'Field moisture is high; monitor disease pressure and avoid overwatering.',
            $moisture >= 45 => 'Field moisture is in a productive range for active crop planning.',
            default => 'Field moisture is trending low; add mulch and irrigate in early morning windows.',
        };

        return [
            'soil_type' => ucfirst($soilType),
            'season' => strtoupper($season),
            'water_headline' => $waterAdjustment['headline'],
            'moisture_note' => $moistureLabel,
            'irrigation_strategy' => $waterAdjustment['irrigation'],
            'weather' => $weather,
            'recommendations' => collect($candidates)
                ->map(function (array $crop) use ($waterAdjustment) {
                    $crop['score'] = max(min($crop['score'] + $waterAdjustment['bonus'], 99), 55);

                    return $crop;
                })
                ->sortByDesc('score')
                ->values()
                ->all(),
        ];
    }
}
