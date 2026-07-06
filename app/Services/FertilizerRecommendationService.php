<?php

namespace App\Services;

use App\Models\Fertilizer;
use App\Models\FertilizerRule;
use RuntimeException;

class FertilizerRecommendationService
{
    public function recommend(array $input): array
    {
        $data = $this->normalize($input);

        if ($this->hasInsufficientData($data)) {
            throw new RuntimeException('Add at least one NPK value/level or visible crop problem before requesting a recommendation.');
        }

        $candidates = $this->scoreCandidates($data);

        if ($candidates === []) {
            return $this->fallback($data);
        }

        usort($candidates, fn ($a, $b) => $b['score'] <=> $a['score']);

        $best = $candidates[0];
        $confidence = min(96, max(35, $best['score']));
        $alternatives = collect(array_slice($candidates, 1, 3))->map(fn ($candidate) => [
            'name' => $candidate['fertilizer']->name,
            'confidence' => min(94, max(35, $candidate['score'])),
            'reason' => $candidate['reasons'][0] ?? 'Alternative nutrient support',
        ])->values()->all();

        return [
            'fertilizer' => $best['fertilizer'],
            'recommended_fertilizer' => $best['fertilizer']->name,
            'fertilizer_type' => $best['fertilizer']->fertilizer_type,
            'confidence' => round($confidence, 2),
            'status' => $this->statusForConfidence($confidence),
            'reason' => array_values(array_unique($best['reasons'])),
            'application_timing' => $this->applicationTiming($data),
            'general_guidance' => $best['guidance'] ?: 'Follow the product label and local agricultural recommendations.',
            'warnings' => array_values(array_unique(array_filter(array_merge(
                $best['warnings'],
                $this->weatherWarnings($data),
                [
                    'Do not over-apply fertilizer.',
                    'Do not mix products without expert guidance.',
                ],
            )))),
            'alternatives' => $alternatives,
            'data_quality_score' => $this->dataQuality($data),
            'missing_information' => $this->missingInformation($data),
            'recommendation_source' => config('services.fertilizer_ml.url') ? 'laravel_rule_engine_ml_ready' : 'laravel_rule_engine',
        ];
    }

    private function scoreCandidates(array $data): array
    {
        $rules = FertilizerRule::query()
            ->with('fertilizer')
            ->where('status', 'active')
            ->whereHas('fertilizer', fn ($query) => $query->where('status', 'active'))
            ->get();

        $candidates = [];

        foreach ($rules as $rule) {
            if (! $this->ruleMatches($rule, $data)) {
                continue;
            }

            $fertilizer = $rule->fertilizer;
            $score = 45 + (int) $rule->priority;
            $reasons = [$rule->reason];
            $warnings = array_filter([$rule->warning, $fertilizer->warnings]);
            $guidance = $rule->general_guidance ?: $fertilizer->application_guidance;

            $score += $this->fertilizerSuitabilityScore($fertilizer, $data, $reasons);

            $key = $fertilizer->getKey();
            if (! isset($candidates[$key])) {
                $candidates[$key] = [
                    'fertilizer' => $fertilizer,
                    'score' => $score,
                    'reasons' => $reasons,
                    'warnings' => $warnings,
                    'guidance' => $guidance,
                ];
                continue;
            }

            $candidates[$key]['score'] += min(20, $score / 4);
            $candidates[$key]['reasons'] = array_merge($candidates[$key]['reasons'], $reasons);
            $candidates[$key]['warnings'] = array_merge($candidates[$key]['warnings'], $warnings);
            $candidates[$key]['guidance'] = $candidates[$key]['guidance'] ?: $guidance;
        }

        return array_values($candidates);
    }

    private function ruleMatches(FertilizerRule $rule, array $data): bool
    {
        foreach (['crop_name', 'soil_type', 'season', 'growth_stage'] as $field) {
            if ($rule->{$field} && strtolower($rule->{$field}) !== strtolower((string) ($data[$field] ?? ''))) {
                return false;
            }
        }

        if ($rule->problem && strtolower($rule->problem) !== strtolower((string) ($data['current_problem'] ?? ''))) {
            return false;
        }

        if ($rule->minimum_ph !== null && ($data['ph_value'] === null || (float) $data['ph_value'] < (float) $rule->minimum_ph)) {
            return false;
        }

        if ($rule->maximum_ph !== null && ($data['ph_value'] === null || (float) $data['ph_value'] > (float) $rule->maximum_ph)) {
            return false;
        }

        $nutrientType = strtolower((string) $rule->nutrient_type);
        if (in_array($nutrientType, ['nitrogen', 'phosphorus', 'potassium'], true)) {
            return $this->nutrientConditionMatches($nutrientType, strtolower($rule->nutrient_condition), $data);
        }

        return true;
    }

    private function nutrientConditionMatches(string $nutrient, string $condition, array $data): bool
    {
        $level = strtolower((string) ($data[$nutrient.'_level'] ?? ''));
        $value = $data[$nutrient.'_value'] ?? null;

        if ($condition === 'low') {
            return $level === 'low' || ($value !== null && (float) $value < $this->threshold($nutrient));
        }

        if ($condition === 'medium') {
            return $level === 'medium';
        }

        if ($condition === 'high') {
            return $level === 'high' || ($value !== null && (float) $value >= $this->threshold($nutrient) * 1.6);
        }

        return true;
    }

    private function fertilizerSuitabilityScore(Fertilizer $fertilizer, array $data, array &$reasons): int
    {
        $score = 0;

        $score += $this->listScore($fertilizer->suitable_crops, $data['crop_name'] ?? null, 'The fertilizer is suitable for the selected crop.', $reasons);
        $score += $this->listScore($fertilizer->suitable_soils, $data['soil_type'] ?? null, 'The fertilizer suits the selected soil type.', $reasons);
        $score += $this->listScore($fertilizer->suitable_growth_stages, $data['growth_stage'] ?? null, 'The fertilizer supports the selected growth stage.', $reasons);
        $score += $this->listScore($fertilizer->problems_addressed, $data['current_problem'] ?? null, 'The fertilizer addresses the selected crop problem.', $reasons);

        if (($data['organic_preference'] ?? '') === 'Organic Fertilizer' && $fertilizer->organic) {
            $score += 12;
            $reasons[] = 'Matches the organic fertilizer preference.';
        }

        if (($data['organic_preference'] ?? '') === 'Chemical Fertilizer' && ! $fertilizer->organic) {
            $score += 8;
        }

        return $score;
    }

    private function listScore(?array $values, ?string $needle, string $reason, array &$reasons): int
    {
        if (! $values || ! $needle) {
            return 0;
        }

        $matches = collect($values)->contains(fn ($value) => strtolower((string) $value) === strtolower($needle));

        if ($matches) {
            $reasons[] = $reason;
            return 8;
        }

        return 0;
    }

    private function fallback(array $data): array
    {
        $fertilizer = Fertilizer::where('status', 'active')->where('name', 'Compost')->first()
            ?: Fertilizer::where('status', 'active')->first();

        return [
            'fertilizer' => $fertilizer,
            'recommended_fertilizer' => $fertilizer?->name ?? 'Expert review required',
            'fertilizer_type' => $fertilizer?->fertilizer_type ?? 'Review',
            'confidence' => 45,
            'status' => $this->statusForConfidence(45),
            'reason' => ['The available information is not enough for a strong fertilizer match.'],
            'application_timing' => $this->applicationTiming($data),
            'general_guidance' => 'Add soil test NPK values or consult an agricultural expert before applying fertilizer.',
            'warnings' => ['Insufficient confidence; request more information or expert review.'],
            'alternatives' => [],
            'data_quality_score' => $this->dataQuality($data),
            'missing_information' => $this->missingInformation($data),
            'recommendation_source' => 'laravel_rule_engine',
        ];
    }

    private function normalize(array $input): array
    {
        foreach (['nitrogen', 'phosphorus', 'potassium'] as $nutrient) {
            $levelKey = $nutrient.'_level';
            $valueKey = $nutrient.'_value';
            if (isset($input[$levelKey])) {
                $input[$levelKey] = ucfirst(strtolower((string) $input[$levelKey]));
            }
            if (isset($input[$valueKey]) && $input[$valueKey] !== '') {
                $input[$valueKey] = (float) $input[$valueKey];
            }
        }

        $input['ph_value'] = isset($input['ph_value']) && $input['ph_value'] !== '' ? (float) $input['ph_value'] : null;

        return $input;
    }

    private function hasInsufficientData(array $data): bool
    {
        return empty($data['current_problem'])
            && empty($data['nitrogen_level']) && empty($data['phosphorus_level']) && empty($data['potassium_level'])
            && ! isset($data['nitrogen_value']) && ! isset($data['phosphorus_value']) && ! isset($data['potassium_value']);
    }

    private function dataQuality(array $data): int
    {
        $fields = ['crop_name', 'soil_type', 'ph_value', 'growth_stage', 'current_problem', 'nitrogen_level', 'phosphorus_level', 'potassium_level', 'nitrogen_value', 'phosphorus_value', 'potassium_value'];
        $filled = collect($fields)->filter(fn ($field) => filled($data[$field] ?? null))->count();

        return min(100, (int) round(($filled / 8) * 100));
    }

    private function missingInformation(array $data): array
    {
        $missing = [];
        foreach (['ph_value' => 'Soil pH', 'growth_stage' => 'Growth stage', 'current_problem' => 'Visible problem'] as $field => $label) {
            if (blank($data[$field] ?? null)) {
                $missing[] = $label;
            }
        }

        if (blank($data['nitrogen_level'] ?? null) && ! isset($data['nitrogen_value'])) {
            $missing[] = 'Nitrogen level or value';
        }
        if (blank($data['phosphorus_level'] ?? null) && ! isset($data['phosphorus_value'])) {
            $missing[] = 'Phosphorus level or value';
        }
        if (blank($data['potassium_level'] ?? null) && ! isset($data['potassium_value'])) {
            $missing[] = 'Potassium level or value';
        }

        return $missing;
    }

    private function applicationTiming(array $data): string
    {
        if (($data['rainfall'] ?? 0) >= 20) {
            return 'Avoid fertilizer application immediately before or during heavy rain.';
        }

        if (str_contains(strtolower((string) ($data['weather_condition'] ?? '')), 'wind')) {
            return 'Avoid foliar application during strong wind and apply only in calm conditions.';
        }

        return 'Apply only when soil has sufficient moisture and heavy rain is not expected.';
    }

    private function weatherWarnings(array $data): array
    {
        $warnings = [];
        if (($data['soil_moisture'] ?? null) !== null && (float) $data['soil_moisture'] < 15) {
            $warnings[] = 'Soil moisture appears low; irrigate appropriately before fertilizer application.';
        }
        if (($data['rainfall'] ?? 0) >= 20) {
            $warnings[] = 'Heavy rain can cause nutrient runoff or leaching.';
        }

        return $warnings;
    }

    private function threshold(string $nutrient): float
    {
        return match ($nutrient) {
            'nitrogen' => 50,
            'phosphorus' => 25,
            'potassium' => 80,
            default => 50,
        };
    }

    private function statusForConfidence(float $confidence): string
    {
        if ($confidence >= 85) {
            return 'Strong recommendation based on available data';
        }

        if ($confidence >= 60) {
            return 'Possible recommendation; verify with soil test';
        }

        return 'Insufficient confidence; request more information or expert review';
    }
}
