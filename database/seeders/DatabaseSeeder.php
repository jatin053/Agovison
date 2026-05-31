<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\DiseaseReport;
use App\Models\User;
use App\Services\DiseaseDetectionService;
use App\Services\WeatherService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
        ]);

        $admin = User::updateOrCreate([
            'email' => 'jatin@gmail.com',
        ], [
            'name' => 'AgroVision Admin',
            'phone' => '9876543210',
            'password' => 'jatin12',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        User::factory(3)->farmer()->create();
        User::factory(3)->buyer()->create();
        User::factory(2)->expert()->create();

        User::firstOrCreate([
            'email' => 'buyer@agrovision.test',
        ], [
            'name' => 'Demo Buyer',
            'phone' => '9123456780',
            'password' => 'password',
            'status' => 'active',
            'email_verified_at' => now(),
        ])->assignRole('Buyer');

        User::firstOrCreate([
            'email' => 'farmer@agrovision.test',
        ], [
            'name' => 'Demo Farmer',
            'phone' => '9234567890',
            'password' => 'password',
            'status' => 'active',
            'email_verified_at' => now(),
        ])->assignRole('Farmer');

        User::firstOrCreate([
            'email' => 'expert@agrovision.test',
        ], [
            'name' => 'Demo Expert',
            'phone' => '9345678901',
            'password' => 'password',
            'status' => 'active',
            'email_verified_at' => now(),
        ])->assignRole('Expert');

        $this->call([
            CropSeeder::class,
            OrderSeeder::class,
            AgroVisionAiSeeder::class,
        ]);

        $weatherService = app(WeatherService::class);
        $diseaseService = app(DiseaseDetectionService::class);
        $farmer = User::role('Farmer')->first();
        $crop = Crop::first();

        if ($farmer) {
            $weatherService->fetchAndStore('Pune', $farmer);
            $weatherService->fetchAndStore('Nashik', $farmer);
        }

        if ($farmer && $crop) {
            $analysis = $diseaseService->analyze(null, 'Seeder demo');

            DiseaseReport::firstOrCreate([
                'user_id' => $farmer->id,
                'crop_id' => $crop->id,
            ], [
                'image_path' => null,
                'predicted_disease' => $analysis['disease'],
                'confidence' => $analysis['confidence'],
                'symptoms' => $analysis['symptoms'],
                'cure' => $analysis['cure'],
                'fertilizer_recommendation' => $analysis['fertilizer_recommendation'],
                'notes' => 'Seeded demo disease report.',
                'status' => 'analyzed',
            ]);
        }

        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'phone' => '9456789012',
            'password' => 'password',
            'status' => 'active',
            'email_verified_at' => now(),
        ])->assignRole('Buyer');
    }
}
