<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'site_title', 'label' => 'Site Title', 'type' => 'text', 'value' => 'AgroVision', 'is_public' => true],
            ['group' => 'general', 'key' => 'support_email', 'label' => 'Support Email', 'type' => 'text', 'value' => 'support@agrovision.test', 'is_public' => true],
            ['group' => 'general', 'key' => 'support_phone', 'label' => 'Support Phone', 'type' => 'text', 'value' => '+91 98765 43210', 'is_public' => true],
            ['group' => 'weather', 'key' => 'default_weather_city', 'label' => 'Default Weather City', 'type' => 'text', 'value' => 'Pune', 'is_public' => false],
            ['group' => 'marketplace', 'key' => 'currency', 'label' => 'Currency', 'type' => 'text', 'value' => 'INR', 'is_public' => true],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
