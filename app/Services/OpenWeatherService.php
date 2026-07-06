<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenWeatherService
{
    public function current(float $latitude, float $longitude): array
    {
        $key = (string) config('services.openweather.key');

        if ($key === '') {
            throw new RuntimeException('OpenWeather API key is not configured.');
        }

        try {
            $response = Http::connectTimeout(5)
                ->timeout(12)
                ->retry(2, 250)
                ->get('https://api.openweathermap.org/data/2.5/weather', [
                    'appid' => $key,
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'units' => 'metric',
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('The live weather service is currently unreachable.', 0, $exception);
        }

        if (! $response->successful()) {
            $message = $response->json('message');

            throw new RuntimeException(
                is_string($message) ? 'OpenWeather error: '.ucfirst($message) : 'OpenWeather returned an invalid response.'
            );
        }

        $data = $response->json();

        if (! is_array($data) || ! isset($data['main']['temp'])) {
            throw new RuntimeException('OpenWeather response did not contain current conditions.');
        }

        return $this->mapConditions($data);
    }

    public function forecast(float $latitude, float $longitude, string $date): array
    {
        if ($date === now()->toDateString()) {
            return $this->current($latitude, $longitude);
        }

        $key = (string) config('services.openweather.key');

        if ($key === '') {
            throw new RuntimeException('OpenWeather API key is not configured.');
        }

        try {
            $response = Http::connectTimeout(5)->timeout(12)->retry(2, 250)
                ->get('https://api.openweathermap.org/data/2.5/forecast', [
                    'appid' => $key,
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'units' => 'metric',
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('The weather forecast service is currently unreachable.', 0, $exception);
        }

        if (! $response->successful()) {
            $message = $response->json('message');
            throw new RuntimeException(is_string($message) ? 'OpenWeather error: '.ucfirst($message) : 'OpenWeather returned an invalid forecast.');
        }

        $timezoneOffset = (int) $response->json('city.timezone', 0);
        $matches = collect($response->json('list', []))
            ->filter(fn (array $item) => CarbonImmutable::createFromTimestampUTC((int) $item['dt'])
                ->addSeconds($timezoneOffset)->toDateString() === $date);

        $conditions = $matches->sortBy(function (array $item) use ($timezoneOffset) {
            $hour = CarbonImmutable::createFromTimestampUTC((int) $item['dt'])->addSeconds($timezoneOffset)->hour;
            return abs(12 - $hour);
        })->first();

        if (! is_array($conditions)) {
            throw new RuntimeException('Forecast is unavailable for the selected date. Choose a date within the next five days.');
        }

        return $this->mapConditions($conditions);
    }

    private function mapConditions(array $data): array
    {
        return [
            'temperature' => round((float) ($data['main']['temp'] ?? 0), 2),
            'humidity' => isset($data['main']['humidity']) ? (float) $data['main']['humidity'] : null,
            'rainfall' => isset($data['rain']['1h'])
                ? (float) $data['rain']['1h']
                : (isset($data['rain']['3h']) ? (float) $data['rain']['3h'] : 0),
            'wind_speed' => isset($data['wind']['speed']) ? round((float) $data['wind']['speed'] * 3.6, 2) : null,
            'cloud_cover' => isset($data['clouds']['all']) ? (float) $data['clouds']['all'] : null,
            'weather_condition' => isset($data['weather'][0]['description'])
                ? ucfirst((string) $data['weather'][0]['description'])
                : null,
            'raw_response' => $data,
        ];
    }
}
