<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Post;
use App\Models\SoilReport;
use App\Models\User;
use App\Services\CropRecommendationService;
use App\Services\IrrigationInsightService;
use Illuminate\Database\Seeder;

class AgroVisionAiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $farmers = User::role('Farmer')->with('crops')->get();
        $buyers = User::role('Buyer')->get();
        $cropRecommendationService = app(CropRecommendationService::class);
        $irrigationInsightService = app(IrrigationInsightService::class);

        foreach ($farmers as $index => $farmer) {
            $post = Post::updateOrCreate([
                'user_id' => $farmer->id,
                'title' => 'Field update #'.($index + 1),
            ], [
                'body' => 'Today we tracked moisture, checked disease hotspots, and planned irrigation using AgroVision AI recommendations.',
                'location' => $farmer->city ?: 'Pune',
                'visibility' => 'public',
                'tags' => ['field-update', 'smart-farming', 'ai'],
            ]);

            foreach ($buyers->take(2) as $buyer) {
                $post->likes()->firstOrCreate([
                    'user_id' => $buyer->id,
                ]);
            }

            $post->allComments()->firstOrCreate([
                'user_id' => $farmers->first()?->id ?? $farmer->id,
                'body' => 'Moisture profile looks good. Did you change your fertigation schedule this week?',
            ]);

            $crop = $farmer->crops->first();

            if (! $crop) {
                continue;
            }

            $report = SoilReport::firstOrCreate([
                'user_id' => $farmer->id,
                'crop_id' => $crop->id,
                'season' => 'kharif',
            ], [
                'soil_type' => 'loamy',
                'ph' => 6.8,
                'nitrogen' => 34,
                'phosphorus' => 18,
                'potassium' => 26,
                'moisture_percentage' => 58,
                'water_level_percentage' => 62,
                'field_size' => 3.5,
                'logged_at' => now()->subDay(),
            ]);

            $recommendation = $cropRecommendationService->recommend([
                'soil_type' => $report->soil_type,
                'season' => $report->season,
                'water_level_percentage' => $report->water_level_percentage,
                'moisture_percentage' => $report->moisture_percentage,
            ], [
                'temperature' => 30,
                'humidity' => 68,
                'rain_prediction' => 42,
                'wind_speed' => 11,
            ]);

            $insight = $irrigationInsightService->analyze($report);

            $report->update([
                'recommendations' => collect($recommendation['recommendations'])->pluck('name')->implode(', ').'. '.implode(' ', $insight['actions']),
                'meta' => ['recommendation' => $recommendation, 'insight' => $insight],
            ]);

            $auction = Auction::updateOrCreate([
                'crop_id' => $crop->id,
                'title' => $crop->title.' Premium Lot Auction',
            ], [
                'farmer_id' => $farmer->id,
                'description' => 'Fresh harvest with quality assurance and smart marketplace bidding.',
                'starting_price' => max((float) $crop->effective_price * 8, 1200),
                'reserve_price' => max((float) $crop->effective_price * 10, 1600),
                'bid_increment' => 50,
                'starts_at' => now()->subHours(4),
                'ends_at' => now()->addHours(18),
                'status' => 'live',
            ]);

            foreach ($buyers->take(2) as $offset => $buyer) {
                $amount = (float) $auction->starting_price + (($offset + 1) * 120);

                $bid = $auction->bids()->firstOrCreate([
                    'user_id' => $buyer->id,
                    'amount' => $amount,
                ], [
                    'note' => 'Seeded marketplace bid',
                ]);

                $auction->update(['winner_id' => $bid->user_id]);
            }
        }
    }
}
