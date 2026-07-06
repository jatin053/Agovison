<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fertilizer_recommendations', function (Blueprint $table) {
            $table->string('nitrogen_level', 20)->nullable()->change();
            $table->string('phosphorus_level', 20)->nullable()->change();
            $table->string('potassium_level', 20)->nullable()->change();
            $table->decimal('ph_value', 4, 2)->nullable()->change();

            if (! Schema::hasColumn('fertilizer_recommendations', 'temperature')) {
                $table->decimal('temperature', 8, 2)->nullable()->after('current_problem');
            }
            if (! Schema::hasColumn('fertilizer_recommendations', 'humidity')) {
                $table->decimal('humidity', 8, 2)->nullable()->after('temperature');
            }
            if (! Schema::hasColumn('fertilizer_recommendations', 'rainfall')) {
                $table->decimal('rainfall', 8, 2)->nullable()->after('humidity');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fertilizer_recommendations', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'humidity', 'rainfall']);
        });
    }
};
