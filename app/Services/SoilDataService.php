<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SoilDataService
{
    public function estimate(float $latitude, float $longitude): array
    {
        $baseUrl = rtrim((string) config('services.soil_api.url'), '/');
        $apiKey = (string) config('services.soil_api.key');

        if ($baseUrl === '') {
            throw new RuntimeException('Soil API is not configured. Continue with manual soil entry.');
        }

        try {
            $request = Http::timeout(20)->acceptJson();

            if ($apiKey !== '') {
                $request = $request->withToken($apiKey);
            }

            $response = $request->get($baseUrl, [
                'lat' => $latitude,
                'lon' => $longitude,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('Soil API is not reachable. Continue with manual soil entry.', 0, $exception);
        }

        if (! $response->ok()) {
            throw new RuntimeException('Soil API returned an error. Continue with manual soil entry.');
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new RuntimeException('Soil API returned invalid data. Continue with manual soil entry.');
        }

        return $this->normalize($payload);
    }

    public function classifyTexture(?float $sand, ?float $clay, ?float $silt): string
    {
        if ($sand === null || $clay === null || $silt === null) {
            return 'Other';
        }

        if ($sand >= 60) {
            return 'Sandy';
        }

        if ($clay >= 40) {
            return 'Clay';
        }

        if ($sand >= 30 && $sand <= 50 && $clay >= 15 && $clay <= 30 && $silt >= 25 && $silt <= 50) {
            return 'Loamy';
        }

        return 'Other';
    }

    private function normalize(array $payload): array
    {
        $sand = $this->number($payload, ['sand_percentage', 'sand', 'sand_percent']);
        $clay = $this->number($payload, ['clay_percentage', 'clay', 'clay_percent']);
        $silt = $this->number($payload, ['silt_percentage', 'silt', 'silt_percent']);

        return [
            'soil_type' => $this->classifyTexture($sand, $clay, $silt),
            'ph_value' => $this->number($payload, ['ph_value', 'ph', 'soil_ph']),
            'organic_carbon' => $this->number($payload, ['organic_carbon', 'ocd', 'carbon']),
            'nitrogen_value' => $this->number($payload, ['nitrogen_value', 'nitrogen', 'n']),
            'soil_moisture' => $this->number($payload, ['soil_moisture', 'moisture']),
            'sand_percentage' => $sand,
            'clay_percentage' => $clay,
            'silt_percentage' => $silt,
            'api_provider' => 'configured_soil_api',
            'api_response' => $payload,
        ];
    }

    private function number(array $payload, array $keys): ?float
    {
        foreach ($keys as $key) {
            if (isset($payload[$key]) && is_numeric($payload[$key])) {
                return (float) $payload[$key];
            }
        }

        return null;
    }
}
