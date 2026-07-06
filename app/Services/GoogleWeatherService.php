<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleWeatherService
{
    public function current(float $latitude, float $longitude): array
    {
        $key = config('services.google.weather_key');

        if (! $key) {
            return $this->emptyWeather();
        }

        $response = Http::timeout(12)->get('https://weather.googleapis.com/v1/currentConditions:lookup', [
            'key' => $key,
            'location.latitude' => $latitude,
            'location.longitude' => $longitude,
        ]);

        if (! $response->ok()) {
            return $this->emptyWeather($response->json());
        }

        $data = $response->json();

        return [
            'temperature' => $data['temperature']['degrees'] ?? null,
            'humidity' => $data['relativeHumidity'] ?? null,
            'rainfall' => $data['precipitation']['qpf']['quantity'] ?? $data['precipitation']['probability']['percent'] ?? null,
            'wind_speed' => $data['wind']['speed']['value'] ?? null,
            'cloud_cover' => $data['cloudCover'] ?? null,
            'weather_condition' => $data['weatherCondition']['description']['text'] ?? null,
            'raw_response' => $data,
        ];
    }

    private function emptyWeather(?array $raw = null): array
    {
        return [
            'temperature' => null,
            'humidity' => null,
            'rainfall' => null,
            'wind_speed' => null,
            'cloud_cover' => null,
            'weather_condition' => null,
            'raw_response' => $raw,
        ];
    }
}
