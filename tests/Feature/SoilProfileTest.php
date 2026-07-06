<?php

namespace Tests\Feature;

use App\Models\SoilProfile;
use App\Models\User;
use App\Services\SoilDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class SoilProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_soil_pages(): void
    {
        $this->get(route('dashboard.soil'))->assertRedirect(route('login'));
    }

    public function test_user_can_create_soil_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.soil.store'), [
            'soil_type' => 'Loamy',
            'ph_value' => 6.8,
            'nitrogen_level' => 'Medium',
            'phosphorus_level' => 'Low',
            'potassium_level' => 'High',
            'data_source' => 'Manual Entry',
        ])->assertRedirect();

        $this->assertDatabaseHas('soil_profiles', [
            'user_id' => $user->id,
            'soil_type' => 'Loamy',
            'data_source' => 'Manual Entry',
        ]);
    }

    public function test_soil_validation_rejects_invalid_ph(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.soil.store'), [
            'soil_type' => 'Loamy',
            'ph_value' => 18,
            'data_source' => 'Manual Entry',
        ])->assertSessionHasErrors('ph_value');
    }

    public function test_user_sees_only_own_soil_profiles(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $ownProfile = SoilProfile::create(['user_id' => $user->id, 'soil_type' => 'Loamy', 'location' => 'Own Test Field', 'data_source' => 'Manual Entry']);
        $otherProfile = SoilProfile::create(['user_id' => $other->id, 'soil_type' => 'Clay', 'location' => 'Other Hidden Field', 'data_source' => 'Manual Entry']);

        $response = $this->actingAs($user)->get(route('dashboard.soil.history'));

        $response->assertSee('Own Test Field');
        $response->assertDontSee('Other Hidden Field');
        $this->actingAs($user)->get(route('dashboard.soil.edit', $otherProfile))->assertForbidden();
        $this->actingAs($user)->get(route('dashboard.soil.edit', $ownProfile))->assertOk();
    }

    public function test_soil_api_failure_falls_back_to_manual_entry(): void
    {
        $user = User::factory()->create();

        $this->app->instance(SoilDataService::class, new class extends SoilDataService {
            public function estimate(float $latitude, float $longitude): array
            {
                throw new RuntimeException('API down');
            }
        });

        $this->actingAs($user)->postJson(route('dashboard.soil.estimate'), [
            'latitude' => 30.7333,
            'longitude' => 76.7794,
        ])->assertOk()->assertJson([
            'ok' => false,
        ]);
    }

    public function test_admin_can_see_all_soil_profiles(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['name' => 'Soil Farmer']);
        SoilProfile::create(['user_id' => $user->id, 'soil_type' => 'Alluvial', 'data_source' => 'Manual Entry']);

        $this->actingAs($admin)->get(route('admin.soil.index'))
            ->assertOk()
            ->assertSee('Soil Farmer')
            ->assertSee('Alluvial');
    }
}
