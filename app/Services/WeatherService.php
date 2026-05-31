<?php

namespace App\Services;

use App\Models\User;
use App\Models\WeatherLog;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function fetchAndStore(string $location, ?User $user = null): WeatherLog
    {
        $data = $this->fetchWeather($location);

        return WeatherLog::create([
            'user_id' => $user?->id,
            'location' => $location,
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
            'rain_prediction' => $data['rain_prediction'],
            'wind_speed' => $data['wind_speed'],
            'condition' => $data['condition'],
            'logged_at' => now(),
            'payload' => $data['payload'],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function fetchWeather(string $location): array
    {
        try {
            $geo = Http::timeout(8)->get('https://geocoding-api.open-meteo.com/v1/search', [
                'name' => $location,
                'count' => 1,
                'language' => 'en',
                'format' => 'json',
            ])->throw()->json();

            $place = $geo['results'][0] ?? null;

            if (! $place) {
                return $this->fallback($location);
            }

            $forecast = Http::timeout(8)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $place['latitude'],
                'longitude' => $place['longitude'],
                'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m',
                'hourly' => 'precipitation_probability',
                'forecast_days' => 1,
                'timezone' => 'auto',
            ])->throw()->json();

            return [
                'temperature' => $forecast['current']['temperature_2m'] ?? null,
                'humidity' => $forecast['current']['relative_humidity_2m'] ?? null,
                'rain_prediction' => collect($forecast['hourly']['precipitation_probability'] ?? [])->max(),
                'wind_speed' => $forecast['current']['wind_speed_10m'] ?? null,
                'condition' => 'Live API',
                'payload' => [
                    'geo' => $place,
                    'forecast' => $forecast,
                ],
            ];
        } catch (\Throwable) {
            return $this->fallback($location);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function fallback(string $location): array
    {
        $seed = abs(crc32($location));

        return [
            'temperature' => 22 + ($seed % 12),
            'humidity' => 55 + ($seed % 30),
            'rain_prediction' => 20 + ($seed % 60),
            'wind_speed' => 5 + ($seed % 15),
            'condition' => 'Fallback Demo Data',
            'payload' => ['source' => 'fallback'],
        ];
    }
}
