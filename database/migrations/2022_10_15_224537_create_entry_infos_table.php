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
            $table->string('sc_number')->nullable();                // スカウトコースX期
            $table->string('sc_number_done')->nullable();           // 修了済みスカウトコースX期
            $table->string('division_number')->nullable();   // 課程別X期
            $table->string('danken')->nullable();   // 団研
            $table->string('furigana');
            $table->string('gender');
            $table->string('bs_id',11);
            $table->date('birthday');
            $table->string('prefecture',50);
            $table->string('district',50);
            $table->string('dan');
            $table->string('troop');
            $table->string('troop_role');               // 団内役務
            $table->string('cell_phone');
            $table->string('zip');
            $table->string('address');
            $table->string('emer_name',20)->nullable();                // 緊急連絡先
            $table->string('emer_relation',20)->nullable();
            $table->string('emer_phone',20)->nullable();
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
            $table->string('wb_adv1_category')->nullable();     // 実修所履歴
            $table->string('wb_adv1_number')->nullable();
            $table->string('wb_adv1_date')->nullable();
            $table->string('wb_adv2_category')->nullable();
            $table->string('wb_adv2_number')->nullable();
            $table->string('wb_adv2_date')->nullable();
            $table->string('wb_adv3_category')->nullable();
            $table->string('wb_adv3_number')->nullable();
            $table->string('wb_adv3_date')->nullable();
            $table->string('service_hist1_role')->nullable();   // 直近5年の奉仕履歴(役務)
            $table->string('service_hist1_term')->nullable();   // 直近5年の奉仕履歴(期間)
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
            $table->string('additional_comment',500)->nullable();   // 地区コミからの副申請書
            $table->string('assignment_sc')->nullable();          // 課題研修SC
            $table->string('assignment_division')->nullable();    // 課題研修課程別
            $table->string('assignment_danken')->nullable();    // 課題研修 団研
            $table->string('face_picture')->nullable();    // 顔写真
            $table->string('uuid')->unique();                   // UUID
            $table->date('trainer_sc_checked_at')->nullable();              // トレーナー認定SC
            $table->string('trainer_sc_name', 50)->nullable();                    // トレーナー認定氏名
            $table->date('trainer_division_checked_at')->nullable();        // トレーナー認定課程別
            $table->string('trainer_division_name', 50)->nullable();              // トレーナー認定氏名
            $table->date('trainer_danken_checked_at')->nullable();              // トレーナー認定SC
            $table->string('trainer_danken_name', 50)->nullable();                    // トレーナー認定氏名
            $table->date('gm_checked_at')->nullable();                      // 団委員長確認
            $table->string('gm_name', 50)->nullable();                         // 団委員長氏名
            $table->date('commi_checked_at')->nullable();                   // 地区コミ確認
            $table->date('ais_checked_at')->nullable();                     // AIS委員会確認
            $table->date('sc_accepted_at')->nullable();                  // AIS委員委員長の参加認定
            $table->date('sc_rejected_at')->nullable();                  // AIS委員委員長の参加認定
            $table->date('div_accepted_at')->nullable();                  // AIS委員委員長の参加認定
            $table->date('div_rejected_at')->nullable();                  // AIS委員委員長の参加認定
            $table->date('danken_accepted_at')->nullable();                  // AIS委員委員長の参加認定
            $table->date('danken_rejected_at')->nullable();                  // AIS委員委員長の参加認定
            $table->string('certification_sc', 5)->nullable();           // 修了認定ステータス pass or ng
            $table->string('certification_div', 5)->nullable();          // 修了認定ステータス pass or ng
            $table->string('certification_danken', 5)->nullable();          // 修了認定ステータス pass or ng
            $table->date('sc_fee_checked_at')->nullable();                     // SC参加費確認
            $table->date('div_fee_checked_at')->nullable();                    // 課程別参加費確認
            $table->date('danken_fee_checked_at')->nullable();                 // 団研参加費確認
            $table->string('order')->nullable();
            $table->string('cancel')->nullable();                        // 欠席情報(SC & 団研)
            $table->string('cancel_div')->nullable();                    // 欠席情報(課程別)
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
