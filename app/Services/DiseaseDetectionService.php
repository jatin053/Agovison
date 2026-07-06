<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class DiseaseDetectionService
{
    public function predict(array $data, UploadedFile $image): array
    {
        $baseUrl = rtrim((string) config('services.disease_api.url'), '/');

        if ($baseUrl === '') {
            throw new RuntimeException('Disease API URL is not configured.');
        }

        try {
            $contents = file_get_contents($image->getRealPath());

            if ($contents === false) {
                throw new RuntimeException('Unable to read the uploaded image.');
            }

            $response = Http::connectTimeout(5)->timeout(60)
                ->attach('image', $contents, $image->getClientOriginalName(), [
                    'Content-Type' => $image->getMimeType() ?: 'application/octet-stream',
                ])
                ->post($baseUrl.'/predict', [
                    'crop_name' => $data['crop_name'],
                    'affected_part' => $data['affected_part'],
                    'symptoms' => $data['symptoms'],
                    'location' => $data['location'],
                    'crop_age' => $data['crop_age'],
                    'symptom_started' => $data['symptom_started'],
                    'field_affected' => $data['field_affected'],
                    'fertilizer_used' => $data['fertilizer_used'] ?? '',
                    'pesticide_used' => $data['pesticide_used'] ?? '',
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('Disease prediction service is not reachable. Please try again later.', 0, $exception);
        }

        if (! $response->successful()) {
            $detail = $response->json('detail');
            throw new RuntimeException(is_string($detail) ? $detail : 'Disease prediction service returned an error.');
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new RuntimeException('Disease prediction service returned invalid JSON.');
        }

        return $this->normalize($payload);
    }

    private function normalize(array $payload): array
    {
        foreach (['crop', 'disease', 'confidence', 'severity', 'possible_cause', 'treatment', 'prevention'] as $key) {
            if (! array_key_exists($key, $payload)) {
                throw new RuntimeException('Disease prediction service response is missing '.$key.'.');
            }
        }

        $confidence = round((float) $payload['confidence'], 2);

        return [
            'disease_name' => (string) $payload['disease'],
            'confidence' => $confidence,
            'severity' => (string) $payload['severity'],
            'possible_cause' => (string) $payload['possible_cause'],
            'treatment' => (string) $payload['treatment'],
            'prevention' => (string) $payload['prevention'],
            'alternatives' => is_array($payload['alternatives'] ?? null) ? $payload['alternatives'] : [],
            'status' => $this->statusForConfidence($confidence),
            'raw_response' => $payload,
            'analysis_source' => (string) ($payload['response_source'] ?? 'python_api'),
        ];
    }

    public function statusForConfidence(float $confidence): string
    {
        if ($confidence >= 85) {
            return 'High-confidence result';
        }

        if ($confidence >= 60) {
            return 'Possible disease. Upload more images or verify with an expert.';
        }

        return 'Unable to confirm the disease reliably. Consult an agricultural expert.';
    }
}
