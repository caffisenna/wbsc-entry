<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * Class Entry_info
 * @package App\Models
 * @version October 15, 2022, 10:45 pm JST
 *
 * @property string $furigana
 * @property string $gender
 * @property string $bs_id
 * @property string $sc_number
 * @property string $sc_number_done
 * @property string $prefecture
 * @property string $district
 * @property string $dan
 * @property string $troop
 * @property string $troop_role
 * @property string $cell_phone
 * @property string $zip
 * @property string $address
 * @property string $emer_name
 * @property string $emer_relation
 * @property string $emer_phone
 * @property string $district_role
 * @property string $prefecture_role
 * @property string $scout_camp
 * @property string $bs_basic_course
 * @property string $wb_basic1_category
 * @property string $wb_basic1_number
 * @property string $wb_basic1_date
 * @property string $wb_adv1_category
 * @property string $wb_adv1_number
 * @property string $wb_adv1_date
 * @property string $service_hist1_role
 * @property string $service_hist1_term
 * @property string $health_illness
 * @property string $health_memo
 * @property string $commi_checked_at
 * @property string $ais_checked_at
 * @property string $gm_checked_at
 * @property string $certification_sc
 * @property string $certification_div
 */
class Entry_info extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'entry_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'sc_number',
        'sc_number_done',
        'division_number',
        'furigana',
        'gender',
        'bs_id',
        'birthday',
        'prefecture',
        'district',
        'dan',
        'troop',
        'troop_role',
        'cell_phone',
        'zip',
        'address',
        'emer_name',
        'emer_relation',
        'emer_phone',
        'district_role',
        'prefecture_role',
        'scout_camp',
        'bs_basic_course',
        'wb_basic1_category',
        'wb_basic1_number',
        'wb_basic1_date',
        'wb_basic2_category',
        'wb_basic2_number',
        'wb_basic2_date',
        'wb_basic3_category',
        'wb_basic3_number',
        'wb_basic3_date',
        'wb_adv1_category',
        'wb_adv1_number',
        'wb_adv1_date',
        'wb_adv2_category',
        'wb_adv2_number',
        'wb_adv2_date',
        'wb_adv3_category',
        'wb_adv3_number',
        'wb_adv3_date',
        'service_hist1_role',
        'service_hist1_term',
        'service_hist2_role',
        'service_hist2_term',
        'service_hist3_role',
        'service_hist3_term',
        'service_hist4_role',
        'service_hist4_term',
        'service_hist5_role',
        'service_hist5_term',
        'health_illness',
        'health_memo',
        'uuid',
        'gm_checked_at',
        'commi_checked_at',
        'ais_checked_at',
        'certification_sc',
        'certification_div',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'sc_number' => 'string',
        'sc_number_done' => 'string',
        'division_number' => 'string',
        'furigana' => 'string',
        'gender' => 'string',
        'bs_id' => 'string',
        'birthday' => 'date',
        'prefecture' => 'string',
        'district' => 'string',
        'dan' => 'string',
        'troop' => 'string',
        'troop_role' => 'string',
        'cell_phone' => 'string',
        'zip' => 'string',
        'address' => 'string',
        'emer_name' => 'string',
        'emer_relation' => 'string',
        'emer_phone' => 'string',
        'district_role' => 'string',
        'prefecture_role' => 'string',
        'scout_camp' => 'string',
        'bs_basic_course' => 'string',
        'wb_basic1_category' => 'string',
        'wb_basic1_number' => 'string',
        'wb_basic1_date' => 'string',
        'wb_basic2_category' => 'string',
        'wb_basic2_number' => 'string',
        'wb_basic2_date' => 'string',
        'wb_basic3_category' => 'string',
        'wb_basic3_number' => 'string',
        'wb_basic3_date' => 'string',
        'wb_adv1_category' => 'string',
        'wb_adv1_number' => 'string',
        'wb_adv1_date' => 'string',
        'wb_adv2_category' => 'string',
        'wb_adv2_number' => 'string',
        'wb_adv2_date' => 'string',
        'wb_adv3_category' => 'string',
        'wb_adv3_number' => 'string',
        'wb_adv3_date' => 'string',
        'service_hist1_role' => 'string',
        'service_hist1_term' => 'string',
        'service_hist2_role' => 'string',
        'service_hist2_term' => 'string',
        'service_hist3_role' => 'string',
        'service_hist3_term' => 'string',
        'service_hist4_role' => 'string',
        'service_hist4_term' => 'string',
        'service_hist5_role' => 'string',
        'service_hist5_term' => 'string',
        'health_illness' => 'string',
        'health_memo' => 'string',
        'uuid' => 'string',
        'gm_checked_at' => 'date',
        'commi_checked_at' => 'date',
        'ais_checked_at' => 'date',
        'trainer_sc_checked_at' => 'date',
        'trainer_sc_name' => 'string',
        'trainer_division_checked_at' => 'date',
        'trainer_division_name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sc_number' => 'required',
        'sc_number_done' => 'required_if:sc_number,done',
        'division_number' => 'required',
        'furigana' => 'required',
        'gender' => 'required',
        'bs_id' => 'required|digits:11',
        'birthday' => 'required|date',
        'prefecture' => 'required',
        'district' => 'required',
        'dan' => 'required',
        'troop' => 'required',
        'troop_role' => 'required',
        'cell_phone' => 'required',
        'zip' => 'required|digits:7',
        'address' => 'required',
        'emer_name' => 'required',
        'emer_relation' => 'required',
        'emer_phone' => 'required',
        'scout_camp' => 'required',
        'bs_basic_course' => 'required',
        'service_hist1_role' => 'required',
        'service_hist1_term' => 'required',
        'health_illness_none' => 'required_if:health_illness,null',
        'health_memo_none' => 'required_if:health_memo,null',
    ];

    public static $messages = [
        'sc_number.required' => 'スカウトコースの期数を選択してください',
        'sc_number_done.required' => 'スカウトコースを修了済みの場合は期数を入力してください',
        'division_number.required' => '課程研修別の期数を選択してください',
        'furigana.required' => 'ふりがなを入力してください',
        'gender.required' => '性別を選択してください',
        'bs_id.required' => '登録番号を入力してください',
        'bs_id.digits' => '登録番号を11桁の半角整数で入力してください。新登録システムから登録番号が11桁に変更になっています。',
        'birthday.required' => '生年月日を入力してください',
        'birthday.date' => '正しい日付を選択して下さい(存在しない年月日)',
        'prefecture.required' => '所属県連盟を選択してください',
        'district.required' => '地区を選択してください',
        'dan.required' => '所属団を入力してください',
        'troop.required' => '所属隊を選択してください',
        'troop_role.required' => '役務を選択してください',
        'cell_phone.required' => 'ケータイを入力してください',
        'zip.required' => '郵便番号を入力してください',
        'zip.digits' => '郵便番号は7桁の半角整数で入力してください',
        'address.required' => '住所を入力してください',
        'scout_camp.required' => 'スカウトキャンプ研修会の修了年月日を入力してください',
        'bs_basic_course.required' => 'ボーイスカウト講習会の修了年月日を入力してください',
        'service_hist1_role.required' => '奉仕歴(1)の役務を入力してください',
        'service_hist1_term.required' => '奉仕歴(1)の奉仕期間を入力してください',
        'emer_name.required' => '緊急連絡先の氏名を入力してください',
        'emer_relation.required' => '緊急連絡先の続柄を入力してください',
        'emer_phone.required' => '緊急連絡先の日中連絡が取れる電話番号を入力してください',
        'health_illness_none.required_if' => '治療中の病気など、申告事項が無い場合はチェックをしてください',
        'health_memo_none.required_if' => '食品アレルギーなどの申告事項が無い場合はチェックをしてください',
    ];

    public function user()
    {
        // return $this->hasOne(user::class);
        return $this->belongsTo(user::class);
    }
}
