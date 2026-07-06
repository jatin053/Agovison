<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yield_predictions', function (Blueprint $table) {
            if (! Schema::hasColumn('yield_predictions', 'soil_profile_id')) {
                $table->foreignId('soil_profile_id')->nullable()->after('weather_data_id')->constrained('soil_profiles')->nullOnDelete();
            }

            if (! Schema::hasColumn('yield_predictions', 'soil_snapshot')) {
                $table->json('soil_snapshot')->nullable()->after('soil_type');
            }
        });

        Schema::table('fertilizer_recommendations', function (Blueprint $table) {
            if (! Schema::hasColumn('fertilizer_recommendations', 'soil_profile_id')) {
                $table->foreignId('soil_profile_id')->nullable()->after('weather_data_id')->constrained('soil_profiles')->nullOnDelete();
            }

            if (! Schema::hasColumn('fertilizer_recommendations', 'soil_snapshot')) {
                $table->json('soil_snapshot')->nullable()->after('soil_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fertilizer_recommendations', function (Blueprint $table) {
            if (Schema::hasColumn('fertilizer_recommendations', 'soil_profile_id')) {
                $table->dropConstrainedForeignId('soil_profile_id');
            }

            if (Schema::hasColumn('fertilizer_recommendations', 'soil_snapshot')) {
                $table->dropColumn('soil_snapshot');
            }
        });

        Schema::table('yield_predictions', function (Blueprint $table) {
            if (Schema::hasColumn('yield_predictions', 'soil_profile_id')) {
                $table->dropConstrainedForeignId('soil_profile_id');
            }

            if (Schema::hasColumn('yield_predictions', 'soil_snapshot')) {
                $table->dropColumn('soil_snapshot');
            }
        });
    }
};
