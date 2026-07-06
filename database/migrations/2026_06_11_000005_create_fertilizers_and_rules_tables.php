<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fertilizers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fertilizer_type');
            $table->decimal('nutrient_n', 8, 2)->default(0);
            $table->decimal('nutrient_p', 8, 2)->default(0);
            $table->decimal('nutrient_k', 8, 2)->default(0);
            $table->json('micronutrients')->nullable();
            $table->json('suitable_crops')->nullable();
            $table->json('suitable_soils')->nullable();
            $table->json('suitable_growth_stages')->nullable();
            $table->json('problems_addressed')->nullable();
            $table->boolean('organic')->default(false);
            $table->text('description');
            $table->text('application_guidance')->nullable();
            $table->text('warnings')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('fertilizer_rules', function (Blueprint $table) {
            $table->id();
            $table->string('crop_name')->nullable();
            $table->string('soil_type')->nullable();
            $table->string('season')->nullable();
            $table->string('growth_stage')->nullable();
            $table->string('nutrient_type');
            $table->string('nutrient_condition');
            $table->decimal('minimum_ph', 4, 2)->nullable();
            $table->decimal('maximum_ph', 4, 2)->nullable();
            $table->string('problem')->nullable();
            $table->foreignId('fertilizer_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('priority')->default(10);
            $table->text('reason');
            $table->text('general_guidance')->nullable();
            $table->text('warning')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fertilizer_rules');
        Schema::dropIfExists('fertilizers');
    }
};
