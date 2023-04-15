<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionListsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('division');
            $table->string('number');
            $table->string('director');
            $table->string('place');
            $table->date('day_start');
            $table->date('guidance_date')->nullable();
            $table->date('deadline');
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
        Schema::drop('division_lists');
    }
}
