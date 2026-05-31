<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Crop;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $farmers = User::role('Farmer')->get()->values();
        $buyers = User::role('Buyer')->get()->values();
        $categories = Category::all()->keyBy(fn (Category $category) => $category->slug);
        $admin = User::role('Admin')->first();

        if ($farmers->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $listings = [
            [
                'category' => 'vegetables',
                'title' => 'Hydroponic Cherry Tomatoes',
                'sku' => 'AV-TOM-101',
                'short_description' => 'Sweet, uniform cherry tomatoes packed for premium retail and restaurant kitchens.',
                'description' => 'Harvested from a protected hydroponic setup with consistent sizing, bright color, and low handling loss for modern fresh-produce buyers.',
                'price' => 78,
                'sale_price' => 72,
                'stock' => 320,
                'unit' => 'kg',
                'location' => 'Pune, Maharashtra',
                'harvest_days' => 2,
                'organic' => true,
                'is_featured' => true,
                'views' => 1480,
                'meta' => [
                    'grade' => 'A+',
                    'packaging' => '5 kg crate',
                    'lead_time' => '24 hours',
                    'min_order' => '25 kg',
                    'certification' => 'Residue checked',
                    'hero_image' => 'https://images.unsplash.com/photo-1592841200221-a6898f307baa?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'vegetables',
                'title' => 'Nashik Red Onion Export Grade',
                'sku' => 'AV-ONI-204',
                'short_description' => 'Storage-friendly red onion lots with strong skin finish and export-style grading.',
                'description' => 'Selected for trading networks that need reliable onion quality, reduced spoilage, and steady dispatch planning for domestic wholesale lanes.',
                'price' => 34,
                'sale_price' => null,
                'stock' => 950,
                'unit' => 'kg',
                'location' => 'Nashik, Maharashtra',
                'harvest_days' => 4,
                'organic' => false,
                'is_featured' => true,
                'views' => 1240,
                'meta' => [
                    'grade' => 'Export',
                    'packaging' => '20 kg mesh bag',
                    'lead_time' => '48 hours',
                    'min_order' => '100 kg',
                    'certification' => 'Market sorted',
                    'hero_image' => 'https://images.unsplash.com/photo-1518977956812-cd3dbadaaf31?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'vegetables',
                'title' => 'Indore Table Potatoes',
                'sku' => 'AV-POT-309',
                'short_description' => 'Clean, medium-size table potatoes ideal for retailers, kitchens, and processors.',
                'description' => 'Bulk-ready potato stock with stable sizing, lower surface damage, and dependable week-ahead availability for trading and institutional supply.',
                'price' => 29,
                'sale_price' => 26,
                'stock' => 1400,
                'unit' => 'kg',
                'location' => 'Indore, Madhya Pradesh',
                'harvest_days' => 3,
                'organic' => false,
                'is_featured' => true,
                'views' => 980,
                'meta' => [
                    'grade' => 'Table',
                    'packaging' => '30 kg sack',
                    'lead_time' => '24-48 hours',
                    'min_order' => '75 kg',
                    'certification' => 'Cold-chain ready',
                    'hero_image' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'spices',
                'title' => 'Guntur Green Chilli Bulk Lot',
                'sku' => 'AV-CHI-118',
                'short_description' => 'Fresh green chilli lots with strong color retention and daily mandi movement.',
                'description' => 'Prepared for fast-moving buyers who need bright green pods, repeatable sizing, and quick dispatch for wholesale vegetable channels.',
                'price' => 92,
                'sale_price' => null,
                'stock' => 260,
                'unit' => 'kg',
                'location' => 'Guntur, Andhra Pradesh',
                'harvest_days' => 1,
                'organic' => false,
                'is_featured' => false,
                'views' => 870,
                'meta' => [
                    'grade' => 'Fresh Select',
                    'packaging' => '8 kg crate',
                    'lead_time' => 'Same day',
                    'min_order' => '20 kg',
                    'certification' => 'Fresh dispatch',
                    'hero_image' => 'https://images.unsplash.com/photo-1588252303782-cb80119abd6d?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'fruits',
                'title' => 'Nagpur Valencia Oranges',
                'sku' => 'AV-ORA-412',
                'short_description' => 'Juicy citrus lots with bright peel finish and dependable carton packing.',
                'description' => 'A fresh-market citrus listing built for retailers and distributors who want sweetness, peel quality, and consistent box presentation.',
                'price' => 86,
                'sale_price' => 81,
                'stock' => 410,
                'unit' => 'kg',
                'location' => 'Nagpur, Maharashtra',
                'harvest_days' => 5,
                'organic' => false,
                'is_featured' => false,
                'views' => 690,
                'meta' => [
                    'grade' => 'Premium',
                    'packaging' => '10 kg carton',
                    'lead_time' => '48 hours',
                    'min_order' => '30 kg',
                    'certification' => 'Size graded',
                    'hero_image' => 'https://images.unsplash.com/photo-1547514701-42782101795e?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'fruits',
                'title' => 'Ratnagiri Alphonso Mangoes',
                'sku' => 'AV-MAN-527',
                'short_description' => 'Signature Alphonso batches selected for aroma, color, and premium gifting demand.',
                'description' => 'Curated mango lots for specialty fruit counters and higher-value buyers who need premium presentation and predictable ripening quality.',
                'price' => 220,
                'sale_price' => 205,
                'stock' => 180,
                'unit' => 'kg',
                'location' => 'Ratnagiri, Maharashtra',
                'harvest_days' => 6,
                'organic' => true,
                'is_featured' => true,
                'views' => 1660,
                'meta' => [
                    'grade' => 'Gift Premium',
                    'packaging' => '4 kg mango box',
                    'lead_time' => '48-72 hours',
                    'min_order' => '12 kg',
                    'certification' => 'Orchard selected',
                    'hero_image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'grains',
                'title' => 'Punjab Basmati Paddy',
                'sku' => 'AV-BAS-611',
                'short_description' => 'Long-grain basmati paddy lots sourced for processors and grain traders.',
                'description' => 'A trading-friendly paddy listing with clean lot handling, moisture monitoring, and quality suited to millers and institutional grain channels.',
                'price' => 58,
                'sale_price' => null,
                'stock' => 2800,
                'unit' => 'kg',
                'location' => 'Ludhiana, Punjab',
                'harvest_days' => 8,
                'organic' => false,
                'is_featured' => false,
                'views' => 760,
                'meta' => [
                    'grade' => 'Milling Select',
                    'packaging' => '50 kg bag',
                    'lead_time' => '72 hours',
                    'min_order' => '250 kg',
                    'certification' => 'Moisture checked',
                    'hero_image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'herbs',
                'title' => 'Baby Spinach Clean Cut',
                'sku' => 'AV-SPI-703',
                'short_description' => 'Tender spinach leaves washed and packed for modern retail and food service use.',
                'description' => 'Leafy greens suited for fast-moving urban supply, with better leaf tenderness, cooler-chain handling, and repeatable batch quality.',
                'price' => 64,
                'sale_price' => null,
                'stock' => 145,
                'unit' => 'kg',
                'location' => 'Bengaluru, Karnataka',
                'harvest_days' => 1,
                'organic' => true,
                'is_featured' => false,
                'views' => 540,
                'meta' => [
                    'grade' => 'Retail Fresh',
                    'packaging' => '2 kg chilled crate',
                    'lead_time' => 'Same day',
                    'min_order' => '10 kg',
                    'certification' => 'Washed and sorted',
                    'hero_image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'category' => 'organic-produce',
                'title' => 'Residue-Free Cucumber Packhouse Lot',
                'sku' => 'AV-CUC-814',
                'short_description' => 'Long cucumber harvests prepared for modern retail displays and salad supply chains.',
                'description' => 'Packhouse-ready cucumbers grown under monitored practices with strong visual uniformity and low handling damage for city distribution.',
                'price' => 48,
                'sale_price' => 44,
                'stock' => 390,
                'unit' => 'kg',
                'location' => 'Nashik, Maharashtra',
                'harvest_days' => 2,
                'organic' => true,
                'is_featured' => false,
                'views' => 620,
                'meta' => [
                    'grade' => 'Residue-Free',
                    'packaging' => '6 kg crate',
                    'lead_time' => '24 hours',
                    'min_order' => '18 kg',
                    'certification' => 'Traceable supply',
                    'hero_image' => 'https://images.unsplash.com/photo-1604977042946-1eecc30f269e?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
        ];

        $reviewTemplates = [
            ['rating' => 5, 'title' => 'Consistent quality', 'review' => 'Uniform grading, fresh arrival, and very low wastage after receiving the lot.'],
            ['rating' => 4, 'title' => 'Reliable dispatch', 'review' => 'The batch reached on time and the packing quality made resale and storage easier.'],
        ];

        foreach ($listings as $index => $listing) {
            $category = $categories->get($listing['category']);
            $farmer = $farmers[$index % $farmers->count()] ?? null;

            if (! $category || ! $farmer) {
                continue;
            }

            $crop = Crop::updateOrCreate(
                ['sku' => $listing['sku']],
                [
                    'user_id' => $farmer->id,
                    'category_id' => $category->id,
                    'approved_by' => $admin?->id,
                    'title' => $listing['title'],
                    'slug' => Str::slug($listing['title']).'-'.Str::lower(Str::afterLast($listing['sku'], '-')),
                    'short_description' => $listing['short_description'],
                    'description' => $listing['description'],
                    'price' => $listing['price'],
                    'sale_price' => $listing['sale_price'],
                    'stock' => $listing['stock'],
                    'unit' => $listing['unit'],
                    'location' => $listing['location'],
                    'harvest_date' => now()->addDays($listing['harvest_days'])->toDateString(),
                    'organic' => $listing['organic'],
                    'is_featured' => $listing['is_featured'],
                    'views' => $listing['views'],
                    'status' => 'approved',
                    'approved_at' => now(),
                    'meta' => $listing['meta'],
                ]
            );

            foreach ($buyers->take(count($reviewTemplates)) as $buyerIndex => $buyer) {
                $template = $reviewTemplates[$buyerIndex];

                Review::updateOrCreate(
                    [
                        'buyer_id' => $buyer->id,
                        'crop_id' => $crop->id,
                        'title' => $template['title'],
                    ],
                    [
                        'rating' => $template['rating'],
                        'review' => $template['review'],
                        'is_approved' => true,
                    ]
                );
            }
        }
    }
}
