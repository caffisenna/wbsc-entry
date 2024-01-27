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
        Schema::create('gm_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();   // 参加者のUUID
            $table->string('name');             // 団委員長氏名
            $table->string('email');            // 団委員長メアド
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gm_addresses');
    }
};
