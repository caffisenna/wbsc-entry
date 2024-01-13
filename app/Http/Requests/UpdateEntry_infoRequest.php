<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Entry_info;

class UpdateEntry_infoRequest extends FormRequest
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
        $birthday = $this->input('bd_year') . '-'. $this->input('bd_month') .'-'.$this->input('bd_day');
        // rules()に渡す値を追加でセット
        //     これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'birthday' => $birthday, // ruleにcastするデータを指定
        ]);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Entry_info::rules();

        return $rules;
    }

    public function messages()
    {
        return Entry_info::$messages;
    }
}
