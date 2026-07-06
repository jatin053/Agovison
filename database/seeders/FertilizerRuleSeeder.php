<?php

namespace Database\Seeders;

use App\Models\Fertilizer;
use App\Models\FertilizerRule;
use Illuminate\Database\Seeder;

class FertilizerRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            ['nitrogen', 'low', 'Urea', 'Low nitrogen may cause yellow leaves and weak vegetative growth.', 'Yellow Leaves', 35],
            ['phosphorus', 'low', 'DAP', 'Low phosphorus may reduce root development.', 'Weak Roots', 35],
            ['potassium', 'low', 'MOP / Potash', 'Low potassium may reduce plant strength and stress tolerance.', 'Poor Plant Strength', 35],
            ['nitrogen', 'low', 'Compost', 'Organic nutrient support can help improve low fertility over time.', null, 18],
            ['phosphorus', 'low', 'Single Super Phosphate', 'Phosphorus support may help weak root development.', 'Weak Roots', 25],
            ['potassium', 'low', 'NPK 10:26:26', 'Balanced NPK support may help crops needing phosphorus and potassium.', null, 20],
        ];

        foreach ($rules as [$nutrient, $condition, $fertilizerName, $reason, $problem, $priority]) {
            $fertilizer = Fertilizer::where('name', $fertilizerName)->first();

            if (! $fertilizer) {
                continue;
            }

            FertilizerRule::updateOrCreate([
                'nutrient_type' => $nutrient,
                'nutrient_condition' => $condition,
                'fertilizer_id' => $fertilizer->id,
                'problem' => $problem,
            ], [
                'priority' => $priority,
                'reason' => $reason,
                'general_guidance' => 'This is a general demonstration rule. Confirm with a current soil test and local expert.',
                'warning' => 'Do not use as exact dosage guidance.',
                'status' => 'active',
            ]);
        }
    }
}
