<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disease_detections', function (Blueprint $table) {
            $table->string('plant_part', 120)->nullable()->after('crop_name');
            $table->string('visible_symptom', 191)->nullable()->after('plant_part');
            $table->text('symptom_notes')->nullable()->after('visible_symptom');
            $table->string('analysis_source', 80)->default('local_rules')->after('confidence_score');
            $table->json('raw_response')->nullable()->after('treatment_suggestion');
        });
    }

    public function down(): void
    {
        Schema::table('disease_detections', function (Blueprint $table) {
            $table->dropColumn([
                'plant_part',
                'visible_symptom',
                'symptom_notes',
                'analysis_source',
                'raw_response',
            ]);
        });
    }
};
