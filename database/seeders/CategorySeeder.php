<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Vegetables',
                'icon' => 'fa-carrot',
                'description' => 'Fresh field and greenhouse vegetables prepared for wholesale, retail, and Horeca supply.',
            ],
            [
                'name' => 'Fruits',
                'icon' => 'fa-apple-whole',
                'description' => 'Seasonal fruit lots with grading, packing, and dispatch-ready inventory from trusted growers.',
            ],
            [
                'name' => 'Grains',
                'icon' => 'fa-wheat-awn',
                'description' => 'Staple grain and cereal harvests suited for processors, traders, and institutional buyers.',
            ],
            [
                'name' => 'Herbs',
                'icon' => 'fa-leaf',
                'description' => 'High-aroma herb batches for fresh-market distribution, kitchens, and specialty retail.',
            ],
            [
                'name' => 'Organic Produce',
                'icon' => 'fa-seedling',
                'description' => 'Residue-conscious and organically managed produce with better traceability and cleaner positioning.',
            ],
            [
                'name' => 'Spices',
                'icon' => 'fa-pepper-hot',
                'description' => 'Dry and fresh spice categories for value-added trade, exports, and bulk procurement.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
