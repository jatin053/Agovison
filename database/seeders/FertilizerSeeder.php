<?php

namespace Database\Seeders;

use App\Models\Fertilizer;
use Illuminate\Database\Seeder;

class FertilizerSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Urea', 'Nitrogen Fertilizer', 46, 0, 0, false, 'General demonstration nitrogen-support fertilizer.'],
            ['DAP', 'Phosphorus Fertilizer', 18, 46, 0, false, 'General demonstration phosphorus-support fertilizer.'],
            ['MOP / Potash', 'Potassium Fertilizer', 0, 0, 60, false, 'General demonstration potassium-support fertilizer.'],
            ['NPK 10:26:26', 'Complex NPK Fertilizer', 10, 26, 26, false, 'General balanced NPK fertilizer with higher P and K.'],
            ['NPK 20:20:20', 'Water Soluble NPK', 20, 20, 20, false, 'General balanced water soluble NPK fertilizer.'],
            ['NPK 12:32:16', 'Complex NPK Fertilizer', 12, 32, 16, false, 'General NPK fertilizer with phosphorus support.'],
            ['Ammonium Sulphate', 'Nitrogen and Sulphur Fertilizer', 21, 0, 0, false, 'Nitrogen and sulphur support.'],
            ['Single Super Phosphate', 'Phosphorus Fertilizer', 0, 16, 0, false, 'Phosphorus and sulphur support.'],
            ['Zinc Sulphate', 'Micronutrient', 0, 0, 0, false, 'Zinc micronutrient support.'],
            ['Ferrous Sulphate', 'Micronutrient', 0, 0, 0, false, 'Iron micronutrient support.'],
            ['Gypsum', 'Soil Amendment', 0, 0, 0, false, 'Calcium and sulphur soil amendment.'],
            ['Agricultural Lime', 'pH Amendment', 0, 0, 0, false, 'Used where expert advice confirms acidic soil correction is needed.'],
            ['Compost', 'Organic Fertilizer', 1, 1, 1, true, 'Organic matter and broad nutrient support.'],
            ['Vermicompost', 'Organic Fertilizer', 1, 1, 1, true, 'Organic nutrient and soil health support.'],
            ['Farmyard Manure', 'Organic Fertilizer', 1, 1, 1, true, 'Organic matter support for soil health.'],
            ['Neem Cake', 'Organic Fertilizer', 4, 1, 1, true, 'Organic nutrient support with soil health benefits.'],
        ];

        foreach ($items as [$name, $type, $n, $p, $k, $organic, $description]) {
            Fertilizer::updateOrCreate(['name' => $name], [
                'fertilizer_type' => $type,
                'nutrient_n' => $n,
                'nutrient_p' => $p,
                'nutrient_k' => $k,
                'organic' => $organic,
                'description' => $description.' This is general demonstration data, not a complete agricultural prescription.',
                'application_guidance' => 'Follow product label, soil test recommendations, and local agricultural expert guidance.',
                'warnings' => 'Do not over-apply. Avoid unsafe mixing without expert guidance.',
                'status' => 'active',
            ]);
        }
    }
}
