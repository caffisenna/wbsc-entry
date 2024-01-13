<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
    public static $rules = [];

    public static $messages = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
