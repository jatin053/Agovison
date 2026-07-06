<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disease_detections', function (Blueprint $table) {
            if (! Schema::hasColumn('disease_detections', 'image_path')) {
                $table->string('image_path', 255)->nullable()->after('crop_name');
            }

            if (! Schema::hasColumn('disease_detections', 'affected_part')) {
                $table->string('affected_part', 120)->nullable()->after('image_path');
            }

            if (! Schema::hasColumn('disease_detections', 'symptoms')) {
                $table->string('symptoms', 191)->nullable()->after('affected_part');
            }

            if (! Schema::hasColumn('disease_detections', 'location')) {
                $table->string('location', 191)->nullable()->after('symptoms');
            }

            if (! Schema::hasColumn('disease_detections', 'crop_age')) {
                $table->string('crop_age', 80)->nullable()->after('location');
            }

            if (! Schema::hasColumn('disease_detections', 'symptom_started')) {
                $table->string('symptom_started', 120)->nullable()->after('crop_age');
            }

            if (! Schema::hasColumn('disease_detections', 'field_affected')) {
                $table->decimal('field_affected', 5, 2)->nullable()->after('symptom_started');
            }

            if (! Schema::hasColumn('disease_detections', 'fertilizer_used')) {
                $table->text('fertilizer_used')->nullable()->after('field_affected');
            }

            if (! Schema::hasColumn('disease_detections', 'pesticide_used')) {
                $table->text('pesticide_used')->nullable()->after('fertilizer_used');
            }

            if (! Schema::hasColumn('disease_detections', 'disease_name')) {
                $table->string('disease_name', 191)->nullable()->after('pesticide_used');
            }

            if (! Schema::hasColumn('disease_detections', 'confidence')) {
                $table->decimal('confidence', 5, 2)->nullable()->after('disease_name');
            }

            if (! Schema::hasColumn('disease_detections', 'possible_cause')) {
                $table->text('possible_cause')->nullable()->after('severity');
            }

            if (! Schema::hasColumn('disease_detections', 'treatment')) {
                $table->text('treatment')->nullable()->after('possible_cause');
            }

            if (! Schema::hasColumn('disease_detections', 'prevention')) {
                $table->text('prevention')->nullable()->after('treatment');
            }

            if (! Schema::hasColumn('disease_detections', 'alternatives')) {
                $table->json('alternatives')->nullable()->after('prevention');
            }

            if (! Schema::hasColumn('disease_detections', 'status')) {
                $table->string('status', 120)->default('pending')->after('alternatives');
            }
        });
    }

    public function down(): void
    {
        Schema::table('disease_detections', function (Blueprint $table) {
            foreach ([
                'image_path',
                'affected_part',
                'symptoms',
                'location',
                'crop_age',
                'symptom_started',
                'field_affected',
                'fertilizer_used',
                'pesticide_used',
                'disease_name',
                'confidence',
                'possible_cause',
                'treatment',
                'prevention',
                'alternatives',
                'status',
            ] as $column) {
                if (Schema::hasColumn('disease_detections', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
