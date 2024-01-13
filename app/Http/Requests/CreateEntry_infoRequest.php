<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Entry_info;
use App\Models\course_list;
use App\Models\division_list;
use Flash;

class CreateEntry_infoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getValidatorInstance()
    {
        // getValidatorInstance でフォームから投稿された値を取得できる
        // ここで取得した値を加工して、バリデーションに渡すことが可能

        // 生年月日処理
        $birthday = $this->input('bd_year') . '-' . $this->input('bd_month') . '-' . $this->input('bd_day');
        // rules()に渡す値を追加でセット
        // これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'birthday' => $birthday, // ruleにcastするデータを指定
        ]);
        // 生年月日処理


        // コースを判定して申込期限を確認
        $sc_number = $this->input('sc_number');

        // 課程別研修の期数
        $div_number = $this->input('division_number');

        // DBからコースの締切日を取得
        if ($sc_number !== 'done' && isset($sc_number)) {
            $course_deadline = course_list::where('number', $sc_number)->value('deadline')->format('Y-m-d');

            // SC 締切日判定
            if ($course_deadline < now()) {
                // msgを表示して前画面へリダイレクト
                // Flash::error("スカウトコース" . $sc_number . "期の申込は" . $course_deadline . "で終了しました");
                $sc_over_deadline = 'true';
                $this->merge([ // input変数へぶっ込む
                    'sc_over_deadline' => $sc_over_deadline,
                ]);
            }
        }

        // DBから課程別研修の締切日を取得
        if ($div_number !== 'etc' && isset($div_number)) {
            $pattern = '/^([A-Z]{2,3})(\d{1,3})$/'; // 課程(アルファベット2-3文字 + 回数1-3桁)を定義
            // 課程と期数をpreg_matchで取得
            if (preg_match($pattern, $div_number, $matches)) {
                $alphabetPart = $matches[1]; // アルファベット部分
                $integerPart = $matches[2];  // 整数部分
            }

            // DBから該当の課程&期数をピックアップ、期限を取得
            $div_deadline = division_list::where('division', $alphabetPart)
                ->where('number', $integerPart)
                ->value('deadline');

            // 課程別研修 締切日判定
            if ($div_deadline < now()) {
                $div_over_deadline = 'true';
                $this->merge([ // input変数へぶっ込む
                    'div_over_deadline' => $div_over_deadline,
                ]);
            }
        }

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Entry_info::rules();
    }

    public function messages()
    {
        return Entry_info::$messages;
    }
}
