<?php

namespace App\Services;

class RecommendationEngine
{
    public function crop(array $data): array
    {
        $season = strtolower((string) $data['season']);
        $soil = strtolower((string) $data['soil_type']);
        $rainfall = (float) ($data['rainfall'] ?? 0);
        $temperature = (float) ($data['temperature'] ?? 0);

        $crop = 'Wheat';

        if (str_contains($season, 'kharif') || $rainfall >= 180) {
            $crop = $temperature >= 24 ? 'Rice' : 'Maize';
        } elseif (str_contains($season, 'summer') || $temperature >= 30) {
            $crop = $soil === 'sandy' ? 'Groundnut' : 'Cotton';
        } elseif ($soil === 'black soil') {
            $crop = 'Cotton';
        } elseif ($soil === 'alluvial') {
            $crop = 'Sugarcane';
        }

        $confidence = min(94, max(68, 70 + (int) ($rainfall / 18) + (int) abs(7 - (float) $data['ph_value'])));

        return [
            'recommended_crop' => $data['crop_name'] ?: $crop,
            'confidence_score' => $confidence,
            'reason' => 'The recommendation matches the selected soil type, season, nutrient profile, pH value, and current weather readings.',
            'farming_advice' => 'Validate seed variety locally, keep irrigation aligned with rainfall, and recheck NPK before the main fertilizer schedule.',
        ];
    }

    public function yield(array $data): array
    {
        $area = (float) $data['land_area'];
        $rainfall = (float) ($data['rainfall'] ?? 0);
        $irrigationBoost = strtolower((string) $data['irrigation_type']) === 'drip' ? 1.15 : 1.0;
        $baseYield = max(0.8, min(6.5, 2.4 + ($rainfall / 180)));
        $expectedYield = round($baseYield * $this->areaInAcres($area, $data['area_unit']) * $irrigationBoost, 2);
        $weatherSummary = $rainfall > 0
            ? "Current rainfall input is {$rainfall} mm."
            : 'No meaningful rainfall is currently recorded.';
        $irrigationSummary = strtolower((string) $data['irrigation_type']) === 'drip'
            ? 'Drip irrigation adds a modest efficiency benefit to this estimate.'
            : 'Keep irrigation timing aligned with field moisture and local weather.';

        return [
            'expected_yield' => $expectedYield,
            'yield_unit' => 'tons',
            'yield_status' => $expectedYield >= 4 ? 'Good potential' : 'Needs attention',
            'advice' => "{$weatherSummary} {$irrigationSummary} Scout the crop regularly and confirm the estimate against local variety performance.",
        ];
    }

    public function fertilizer(array $data): array
    {
        $needs = [];
        $reasons = [];

        if ((float) $data['nitrogen_level'] < 50) {
            $needs[] = 'Urea';
            $reasons[] = 'Low nitrogen may cause yellow leaves and weak vegetative growth.';
        }

        if ((float) $data['phosphorus_level'] < 25) {
            $needs[] = 'DAP';
            $reasons[] = 'Low phosphorus may reduce root development and early crop strength.';
        }

        if ((float) $data['potassium_level'] < 80) {
            $needs[] = 'MOP';
            $reasons[] = 'Low potassium may reduce plant strength, stress tolerance, and grain or fruit quality.';
        }

        if (isset($data['ph_value']) && ((float) $data['ph_value'] < 5.5 || (float) $data['ph_value'] > 8.0)) {
            $reasons[] = 'Very low or high pH can affect nutrient availability, so soil correction may be needed before heavy fertilizer use.';
        }

        $fertilizer = $needs ? implode(' + ', $needs) : 'Balanced NPK 19:19:19';

        return [
            'recommended_fertilizer' => $fertilizer,
            'dosage_advice' => 'Use label dosage only after checking a recent soil test report or local agriculture officer guidance.',
            'application_timing' => 'Apply in split doses around active growth stages; avoid heavy rain and peak afternoon heat.',
            'reason' => $reasons ? implode(' ', $reasons) : 'The soil nutrient levels appear balanced, so a balanced NPK option is suggested for general support.',
            'caution' => 'Fertilizer recommendations are general guidance. Actual application should follow a recent soil test and local agricultural expert advice.',
        ];
    }

    public function weatherAdvice(array $weather): string
    {
        if (($weather['rainfall'] ?? 0) > 20) {
            return 'Delay spraying and avoid waterlogging by checking drainage channels.';
        }

        if (($weather['temperature'] ?? 0) >= 34) {
            return 'Prefer early morning irrigation and avoid fertilizer application during peak heat.';
        }

        return 'Weather is workable for routine farm operations. Monitor local updates before spraying.';
    }

    private function areaInAcres(float $area, string $unit): float
    {
        return match (strtolower($unit)) {
            'hectare', 'hectares' => $area * 2.47105,
            'bigha' => $area * 0.625,
            default => $area,
        };
    }
}
