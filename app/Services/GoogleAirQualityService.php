<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Kept under the original class name to avoid breaking controller injection.
 * Air-quality data now comes from OpenWeather, using the configured weather key.
 */
class GoogleAirQualityService
{
    public function current(float $latitude, float $longitude): array
    {
        $key = (string) config('services.openweather.key');

        if ($key === '') {
            throw new RuntimeException('OpenWeather API key is not configured.');
        }

        try {
            $response = Http::connectTimeout(5)->timeout(12)->retry(2, 250)
                ->get('https://api.openweathermap.org/data/2.5/air_pollution', [
                    'appid' => $key,
                    'lat' => $latitude,
                    'lon' => $longitude,
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('The air-quality service is currently unreachable.', 0, $exception);
        }

        if (! $response->successful()) {
            $message = $response->json('message');
            throw new RuntimeException(is_string($message) ? 'OpenWeather air-quality error: '.ucfirst($message) : 'Air-quality lookup failed.');
        }

        $data = $response->json();
        $index = (int) ($data['list'][0]['main']['aqi'] ?? 0);
        $components = $data['list'][0]['components'] ?? [];

        if ($index < 1 || $index > 5) {
            throw new RuntimeException('Air-quality data is unavailable for this location.');
        }

        $categories = [
            1 => 'Good',
            2 => 'Fair',
            3 => 'Moderate',
            4 => 'Poor',
            5 => 'Very Poor',
        ];

        return [
            'air_quality_index' => $index,
            'air_quality_category' => $categories[$index],
            'dominant_pollutant' => $this->dominantPollutant($components),
            'air_quality_raw' => $data,
        ];
    }

    private function dominantPollutant(array $components): ?string
    {
        $limits = [
            'co' => 4000,
            'no2' => 25,
            'o3' => 100,
            'so2' => 40,
            'pm2_5' => 15,
            'pm10' => 45,
            'nh3' => 200,
        ];
        $ratios = [];

        foreach ($limits as $pollutant => $limit) {
            if (isset($components[$pollutant])) {
                $ratios[$pollutant] = (float) $components[$pollutant] / $limit;
            }
        }

        if ($ratios === []) {
            return null;
        }

        arsort($ratios);

        return match (array_key_first($ratios)) {
            'pm2_5' => 'PM2.5',
            'pm10' => 'PM10',
            default => strtoupper((string) array_key_first($ratios)),
        };
    }
}
