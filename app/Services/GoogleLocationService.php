<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GoogleLocationService
{
    public function geocode(string $location): ?array
    {
        $key = config('services.google.maps_key');

        if ($key) {
            $response = Http::timeout(10)->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $location,
                'key' => $key,
            ]);

            if ($response->ok() && $response->json('status') === 'OK') {
                $result = $response->json('results.0');
                $geometry = $result['geometry']['location'] ?? null;

                if ($geometry) {
                    return [
                        'name' => $result['formatted_address'] ?? $location,
                        'latitude' => $geometry['lat'] ?? null,
                        'longitude' => $geometry['lng'] ?? null,
                    ];
                }
            }
        }

        $openWeatherKey = config('services.openweather.key');

        if (! $openWeatherKey) {
            return null;
        }

        $response = Http::connectTimeout(5)->timeout(10)->get('https://api.openweathermap.org/geo/1.0/direct', [
            'q' => $location,
            'limit' => 1,
            'appid' => $openWeatherKey,
        ]);

        if (! $response->successful() || ! is_array($response->json('0'))) {
            return null;
        }

        $result = $response->json('0');
        $name = implode(', ', array_filter([
            $result['name'] ?? $location,
            $result['state'] ?? null,
            $result['country'] ?? null,
        ]));

        return [
            'name' => $name ?: $location,
            'latitude' => $result['lat'] ?? null,
            'longitude' => $result['lon'] ?? null,
        ];
    }

    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        $key = config('services.openweather.key');

        if (! $key) {
            return null;
        }

        try {
            $response = Http::connectTimeout(8)->timeout(15)->retry(2, 300)
                ->get('https://api.openweathermap.org/geo/1.0/reverse', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'limit' => 1,
                    'appid' => $key,
                ]);
        } catch (ConnectionException) {
            return null;
        }

        if (! $response->successful() || ! is_array($response->json('0'))) {
            return null;
        }

        $result = $response->json('0');
        $name = implode(', ', array_filter([
            $result['name'] ?? null,
            $result['state'] ?? null,
            $result['country'] ?? null,
        ]));

        if ($name === '') {
            return null;
        }

        return [
            'name' => $name,
            'latitude' => $result['lat'] ?? $latitude,
            'longitude' => $result['lon'] ?? $longitude,
        ];
    }
}
