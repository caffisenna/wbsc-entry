<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Entry_info;

class HealthInfo extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'user_id',
        'treating_disease',
        'carried_medications',
        'health_status_last_3_months',
        'recent_health_status',
        'doctor_advice',
        'medical_history',
        'food_allergies',
        'allergen',
        'reaction_to_allergen',
        'usual_response_to_reaction',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'treating_disease' => 'string',
        'carried_medications' => 'string',
        'health_status_last_3_months' => 'string',
        'recent_health_status' => 'string',
        'doctor_advice' => 'string',
        'medical_history' => 'string',
        'food_allergies' => 'string',
        'allergen' => 'string',
        'reaction_to_allergen' => 'string',
        'usual_response_to_reaction' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'treating_disease' => 'required_unless:treating_disease_cb,',
        'recent_health_status' => 'required_unless:recent_health_status_cb,',
        'doctor_advice' => 'required_unless:doctor_advice_cb,',
        'medical_history' => 'required_unless:medical_history_cb,',
    ];

    public static $messages = [
        'treating_disease.required_unless' => '治療中の病気を記入してください。治療中のものがなければ「特になし」にチェックをしてください。',
        'recent_health_status.required_unless' => '最近の体調を記入してください。異常がなければ「特に異常なし」にチェックをしてください。',
        'doctor_advice.required_unless' => '医師からの注意を記入してください。医師からの注意がなければ「特になし」にチェックをしてください。',
        'medical_history.required_unless' => '特記事項、過去の傷病等を記入してください。特になければ「特になし」にチェックをしてください。',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entry_info()
    {
        return $this->hasOne(Entry_Info::class, 'user_id', 'user_id');
    }
}
