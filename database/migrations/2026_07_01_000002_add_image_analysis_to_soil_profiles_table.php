<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soil_profiles', function (Blueprint $table) {
            $table->string('crop_name', 120)->nullable()->after('soil_type');
            $table->string('soil_image_path')->nullable()->after('crop_name');
            $table->decimal('confidence', 5, 2)->nullable()->after('soil_image_path');
            $table->text('crop_advice')->nullable()->after('confidence');
            $table->string('analysis_source', 120)->nullable()->after('crop_advice');
        });
    }

    public function down(): void
    {
        Schema::table('soil_profiles', function (Blueprint $table) {
            $table->dropColumn(['crop_name', 'soil_image_path', 'confidence', 'crop_advice', 'analysis_source']);
        });
    }
};
