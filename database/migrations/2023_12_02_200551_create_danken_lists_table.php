<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danken_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->string('director');
            $table->string('place');
            $table->date('day_start');
            $table->date('day_end');
            $table->date('guidance_date')->nullable();
            $table->date('deadline');
            $table->string('drive_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('danken_lists');
    }
};
