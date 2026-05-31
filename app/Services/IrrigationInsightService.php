<?php

namespace App\Services;

use App\Models\SoilReport;

class IrrigationInsightService
{
    /**
     * @return array<string, mixed>
     */
    public function analyze(SoilReport $report): array
    {
        $moisture = (float) $report->moisture_percentage;
        $waterLevel = (float) $report->water_level_percentage;

        $status = match (true) {
            $moisture < 35 || $waterLevel < 30 => 'critical',
            $moisture < 50 || $waterLevel < 45 => 'watch',
            default => 'healthy',
        };

        $headline = match ($status) {
            'critical' => 'Immediate irrigation attention required.',
            'watch' => 'Irrigation window is tightening.',
            default => 'Soil and water reserves are in a productive range.',
        };

        $actions = match ($status) {
            'critical' => [
                'Run short irrigation cycles at dawn and dusk.',
                'Increase mulching to reduce evaporation losses.',
                'Shift crop plan toward lower water-demand varieties.',
            ],
            'watch' => [
                'Monitor moisture daily and use drip intervals.',
                'Prepare backup water storage for the next 5-7 days.',
                'Apply fertilizer only after moisture stabilizes.',
            ],
            default => [
                'Maintain current scheduling and keep sensor readings consistent.',
                'Continue weekly moisture checks for disease prevention.',
                'Use fertigation in low-wind morning windows.',
            ],
        };

        return [
            'status' => $status,
            'headline' => $headline,
            'actions' => $actions,
            'efficiency_score' => max(min((int) round(($moisture * 0.55) + ($waterLevel * 0.45)), 99), 18),
        ];
    }
}
