<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('health_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('treating_disease')->nullable();
            $table->string('carried_medications')->nullable();
            $table->string('health_status_last_3_months')->nullable();
            $table->string('recent_health_status')->nullable();
            $table->string('doctor_advice')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('food_allergies')->nullable();
            $table->string('allergen')->nullable();
            $table->string('reaction_to_allergen')->nullable();
            $table->string('usual_response_to_reaction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_infos');
    }
};
