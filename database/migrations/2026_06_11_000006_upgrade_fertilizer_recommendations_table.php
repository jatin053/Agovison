<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fertilizer_recommendations', function (Blueprint $table) {
            $columns = Schema::getColumnListing('fertilizer_recommendations');

            if (! in_array('location', $columns, true)) {
                $table->string('location')->nullable()->after('crop_name');
            }
            if (! in_array('nitrogen_value', $columns, true)) {
                $table->decimal('nitrogen_value', 10, 2)->nullable()->after('nitrogen_level');
            }
            if (! in_array('phosphorus_value', $columns, true)) {
                $table->decimal('phosphorus_value', 10, 2)->nullable()->after('phosphorus_level');
            }
            if (! in_array('potassium_value', $columns, true)) {
                $table->decimal('potassium_value', 10, 2)->nullable()->after('potassium_level');
            }
            if (! in_array('irrigation_type', $columns, true)) {
                $table->string('irrigation_type')->nullable()->after('current_problem');
            }
            if (! in_array('previous_fertilizer', $columns, true)) {
                $table->string('previous_fertilizer')->nullable()->after('irrigation_type');
            }
            if (! in_array('last_application_date', $columns, true)) {
                $table->date('last_application_date')->nullable()->after('previous_fertilizer');
            }
            if (! in_array('organic_preference', $columns, true)) {
                $table->string('organic_preference')->nullable()->after('last_application_date');
            }
            if (! in_array('notes', $columns, true)) {
                $table->text('notes')->nullable()->after('organic_preference');
            }
            if (! in_array('weather_condition', $columns, true)) {
                $weatherColumn = $table->string('weather_condition')->nullable();

                $weatherColumn->after(
                    in_array('rainfall', $columns, true) ? 'rainfall' : 'current_problem'
                );
            }
            if (! in_array('recommended_fertilizer_id', $columns, true)) {
                $table->foreignId('recommended_fertilizer_id')->nullable()->after('weather_condition')->constrained('fertilizers')->nullOnDelete();
            }
            if (! in_array('recommended_fertilizer_name', $columns, true)) {
                $table->string('recommended_fertilizer_name')->nullable()->after('recommended_fertilizer_id');
            }
            if (! in_array('confidence', $columns, true)) {
                $table->decimal('confidence', 5, 2)->nullable()->after('recommended_fertilizer_name');
            }
            if (! in_array('general_guidance', $columns, true)) {
                $table->text('general_guidance')->nullable()->after('application_timing');
            }
            if (! in_array('warnings', $columns, true)) {
                $table->json('warnings')->nullable()->after('general_guidance');
            }
            if (! in_array('alternatives', $columns, true)) {
                $table->json('alternatives')->nullable()->after('warnings');
            }
            if (! in_array('recommendation_source', $columns, true)) {
                $table->string('recommendation_source')->default('laravel_rule_engine')->after('alternatives');
            }
            if (! in_array('status', $columns, true)) {
                $table->string('status')->default('Possible recommendation; verify with soil test')->after('recommendation_source');
            }
            if (! in_array('admin_reviewed', $columns, true)) {
                $table->boolean('admin_reviewed')->default(false)->after('status');
            }
            if (! in_array('admin_note', $columns, true)) {
                $table->text('admin_note')->nullable()->after('admin_reviewed');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fertilizer_recommendations', function (Blueprint $table) {
            foreach ([
                'location', 'nitrogen_value', 'phosphorus_value', 'potassium_value', 'irrigation_type',
                'previous_fertilizer', 'last_application_date', 'organic_preference', 'notes',
                'weather_condition', 'recommended_fertilizer_name', 'confidence', 'general_guidance',
                'warnings', 'alternatives', 'recommendation_source', 'status', 'admin_reviewed', 'admin_note',
            ] as $column) {
                if (Schema::hasColumn('fertilizer_recommendations', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('fertilizer_recommendations', 'recommended_fertilizer_id')) {
                $table->dropConstrainedForeignId('recommended_fertilizer_id');
            }
        });
    }
};
