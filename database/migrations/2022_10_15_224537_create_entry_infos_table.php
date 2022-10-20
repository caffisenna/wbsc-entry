<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryInfosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('sc_number');                // スカウトコースX期
            $table->string('division_number');   // 課程別X期
            $table->string('furigana');
            $table->string('gender');
            $table->string('bs_id');
            $table->date('birthday');
            $table->string('prefecture');
            $table->string('district');
            $table->string('dan');
            $table->string('troop');
            $table->string('troop_role');               // 団内役務
            $table->string('cell_phone');
            $table->string('zip');
            $table->string('address');
            $table->string('district_role')->nullable();
            $table->string('prefecture_role')->nullable();
            $table->string('scout_camp');               // スカキャン
            $table->string('bs_basic_course');          // BS講習会
            $table->string('wb_basic1_category')->nullable();   // 研修所履歴
            $table->string('wb_basic1_number')->nullable();
            $table->string('wb_basic1_date')->nullable();
            $table->string('wb_basic2_category')->nullable();
            $table->string('wb_basic2_number')->nullable();
            $table->string('wb_basic2_date')->nullable();
            $table->string('wb_basic3_category')->nullable();
            $table->string('wb_basic3_number')->nullable();
            $table->string('wb_basic3_date')->nullable();
            $table->string('wb_basic4_category')->nullable();
            $table->string('wb_basic4_number')->nullable();
            $table->string('wb_basic4_date')->nullable();
            $table->string('wb_basic5_category')->nullable();
            $table->string('wb_basic5_number')->nullable();
            $table->string('wb_basic5_date')->nullable();
            $table->string('wb_adv1_category')->nullable();     // 実修所履歴
            $table->string('wb_adv1_number')->nullable();
            $table->string('wb_adv1_date')->nullable();
            $table->string('wb_adv2_category')->nullable();
            $table->string('wb_adv2_number')->nullable();
            $table->string('wb_adv2_date')->nullable();
            $table->string('wb_adv3_category')->nullable();
            $table->string('wb_adv3_number')->nullable();
            $table->string('wb_adv3_date')->nullable();
            $table->string('wb_adv4_category')->nullable();
            $table->string('wb_adv4_number')->nullable();
            $table->string('wb_adv4_date')->nullable();
            $table->string('wb_adv5_category')->nullable();
            $table->string('wb_adv5_number')->nullable();
            $table->string('wb_adv5_date')->nullable();
            $table->string('service_hist1_role');               // 直近5年の奉仕履歴(役務)
            $table->string('service_hist1_term');               // 直近5年の奉仕履歴(期間)
            $table->string('service_hist2_role')->nullable();
            $table->string('service_hist2_term')->nullable();
            $table->string('service_hist3_role')->nullable();
            $table->string('service_hist3_term')->nullable();
            $table->string('service_hist4_role')->nullable();
            $table->string('service_hist4_term')->nullable();
            $table->string('service_hist5_role')->nullable();
            $table->string('service_hist5_term')->nullable();
            $table->string('health_illness')->nullable();       // 病気など
            $table->string('health_memo')->nullable();          // 健康上の留意点
            $table->string('assignment_sc')->nullable();          // 課題研修SC
            $table->string('assignment_division')->nullable();    // 課題研修課程別
            $table->uuid('uuid')->nullable();                   // UUID
            $table->date('gm_checked_at')->nullable();                      // 団委員長確認
            $table->date('commi_checked_at')->nullable();                   // 地区コミ確認
            $table->date('ais_checked_at')->nullable();                     // AIS委員会確認
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
        Schema::drop('entry_infos');
    }
}
