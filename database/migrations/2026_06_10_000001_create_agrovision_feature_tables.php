<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('location_name', 191);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('temperature', 8, 2)->nullable();
            $table->decimal('humidity', 8, 2)->nullable();
            $table->decimal('rainfall', 8, 2)->nullable();
            $table->decimal('wind_speed', 8, 2)->nullable();
            $table->decimal('cloud_cover', 8, 2)->nullable();
            $table->string('weather_condition', 191)->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();
        });

        Schema::create('crop_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weather_data_id')->nullable()->constrained('weather_data')->nullOnDelete();
            $table->string('crop_name', 191)->nullable();
            $table->string('location_name', 191);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('soil_type', 80);
            $table->decimal('temperature', 8, 2)->nullable();
            $table->decimal('humidity', 8, 2)->nullable();
            $table->decimal('rainfall', 8, 2)->nullable();
            $table->decimal('ph_value', 4, 2);
            $table->decimal('nitrogen', 8, 2);
            $table->decimal('phosphorus', 8, 2);
            $table->decimal('potassium', 8, 2);
            $table->string('season', 80);
            $table->string('recommended_crop', 191);
            $table->unsignedTinyInteger('confidence_score');
            $table->text('reason');
            $table->text('farming_advice');
            $table->timestamps();
        });

        Schema::create('yield_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weather_data_id')->nullable()->constrained('weather_data')->nullOnDelete();
            $table->string('crop_name', 191);
            $table->string('location_name', 191);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('land_area', 10, 2);
            $table->string('area_unit', 40);
            $table->string('season', 80);
            $table->string('soil_type', 80);
            $table->string('irrigation_type', 100);
            $table->string('previous_crop', 191)->nullable();
            $table->decimal('temperature', 8, 2)->nullable();
            $table->decimal('humidity', 8, 2)->nullable();
            $table->decimal('rainfall', 8, 2)->nullable();
            $table->decimal('expected_yield', 10, 2);
            $table->string('yield_unit', 60)->default('tons');
            $table->string('yield_status', 120);
            $table->text('advice');
            $table->timestamps();
        });

        Schema::create('fertilizer_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weather_data_id')->nullable()->constrained('weather_data')->nullOnDelete();
            $table->string('crop_name', 191);
            $table->string('location_name', 191);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('soil_type', 80);
            $table->string('season', 80);
            $table->string('growth_stage', 120);
            $table->decimal('nitrogen_level', 8, 2);
            $table->decimal('phosphorus_level', 8, 2);
            $table->decimal('potassium_level', 8, 2);
            $table->decimal('ph_value', 4, 2);
            $table->text('current_problem')->nullable();
            $table->string('recommended_fertilizer', 191);
            $table->text('dosage_advice');
            $table->text('application_timing');
            $table->text('reason');
            $table->text('caution');
            $table->timestamps();
        });

        Schema::create('weather_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weather_data_id')->nullable()->constrained('weather_data')->nullOnDelete();
            $table->string('location_name', 191);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('temperature', 8, 2)->nullable();
            $table->decimal('humidity', 8, 2)->nullable();
            $table->decimal('rainfall', 8, 2)->nullable();
            $table->decimal('wind_speed', 8, 2)->nullable();
            $table->decimal('cloud_cover', 8, 2)->nullable();
            $table->string('weather_condition', 191)->nullable();
            $table->text('farming_advice');
            $table->timestamps();
        });

        Schema::create('disease_detections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('crop_name', 191);
            $table->string('leaf_image_path', 255);
            $table->string('detected_disease', 191);
            $table->string('severity', 80);
            $table->unsignedTinyInteger('confidence_score');
            $table->text('treatment_suggestion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disease_detections');
        Schema::dropIfExists('weather_searches');
        Schema::dropIfExists('fertilizer_recommendations');
        Schema::dropIfExists('yield_predictions');
        Schema::dropIfExists('crop_recommendations');
        Schema::dropIfExists('weather_data');
    }
};
