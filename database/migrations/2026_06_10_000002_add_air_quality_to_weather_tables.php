<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->unsignedSmallInteger('air_quality_index')->nullable()->after('weather_condition');
            $table->string('air_quality_category', 120)->nullable()->after('air_quality_index');
            $table->string('dominant_pollutant', 120)->nullable()->after('air_quality_category');
            $table->json('air_quality_raw')->nullable()->after('dominant_pollutant');
        });

        Schema::table('weather_searches', function (Blueprint $table) {
            $table->unsignedSmallInteger('air_quality_index')->nullable()->after('weather_condition');
            $table->string('air_quality_category', 120)->nullable()->after('air_quality_index');
            $table->string('dominant_pollutant', 120)->nullable()->after('air_quality_category');
        });
    }

    public function down(): void
    {
        Schema::table('weather_searches', function (Blueprint $table) {
            $table->dropColumn(['air_quality_index', 'air_quality_category', 'dominant_pollutant']);
        });

        Schema::table('weather_data', function (Blueprint $table) {
            $table->dropColumn(['air_quality_index', 'air_quality_category', 'dominant_pollutant', 'air_quality_raw']);
        });
    }
};
