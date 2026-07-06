<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SoilImageAnalysisService
{
    public function predict(UploadedFile $image): array
    {
        $baseUrl = rtrim((string) config('services.soil_image_api.url'), '/');
        $contents = file_get_contents($image->getRealPath());

        if ($baseUrl === '' || $contents === false) {
            throw new RuntimeException('Soil image service is not configured correctly.');
        }

        try {
            $response = Http::connectTimeout(5)->timeout(180)
                ->attach('image', $contents, $image->getClientOriginalName(), [
                    'Content-Type' => $image->getMimeType() ?: 'application/octet-stream',
                ])
                ->post($baseUrl.'/predict-soil');
        } catch (ConnectionException $exception) {
            throw new RuntimeException('Soil image analysis service is not reachable.', 0, $exception);
        }

        if (! $response->successful()) {
            $detail = $response->json('detail');
            throw new RuntimeException(is_string($detail) ? $detail : 'Soil image analysis failed.');
        }

        $payload = $response->json();

        if (! is_array($payload) || ! isset($payload['soil_type'], $payload['confidence'])) {
            throw new RuntimeException('Soil image service returned an invalid result.');
        }

        return [
            'soil_type' => (string) $payload['soil_type'],
            'confidence' => round((float) $payload['confidence'], 2),
            'analysis_source' => (string) ($payload['response_source'] ?? 'soil_image_api'),
            'raw_response' => $payload,
        ];
    }
}
