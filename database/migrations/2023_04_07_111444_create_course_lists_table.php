<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseListsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // スカウトコースだけ
        Schema::create('course_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');   // スカウトコース期数
            $table->string('director'); // 所長
            $table->string('place');    // 場所
            $table->date('day_start');  // 開始日
            $table->date('day_end')->nullable();    // 終了日
            $table->date('guidance_date')->nullable();  // 説明会
            $table->date('deadline');       // 申込締め切り
            $table->string('drive_url');    // 共有ドライブ
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
        Schema::drop('course_lists');
    }
}
