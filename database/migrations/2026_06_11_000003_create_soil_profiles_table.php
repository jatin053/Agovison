<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('soil_type', 80);
            $table->decimal('ph_value', 4, 2)->nullable();
            $table->string('nitrogen_level', 20)->nullable();
            $table->string('phosphorus_level', 20)->nullable();
            $table->string('potassium_level', 20)->nullable();
            $table->decimal('nitrogen_value', 10, 2)->nullable();
            $table->decimal('phosphorus_value', 10, 2)->nullable();
            $table->decimal('potassium_value', 10, 2)->nullable();
            $table->decimal('organic_carbon', 8, 2)->nullable();
            $table->decimal('soil_moisture', 8, 2)->nullable();
            $table->decimal('soil_temperature', 8, 2)->nullable();
            $table->decimal('sand_percentage', 8, 2)->nullable();
            $table->decimal('clay_percentage', 8, 2)->nullable();
            $table->decimal('silt_percentage', 8, 2)->nullable();
            $table->date('soil_test_date')->nullable();
            $table->string('data_source', 80);
            $table->string('api_provider')->nullable();
            $table->json('api_response')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_note')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_profiles');
    }
};
