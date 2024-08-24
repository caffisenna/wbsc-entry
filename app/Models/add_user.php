<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class add_user extends Model
{
    public $table = 'add_users';

    public $fillable = [
        'name',
        'email',
        'role',
        'district',
        'password',
        'is_admin',
        'is_ais',
        'is_commi',
        'is_course_staff',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'role' => 'string',
        'district' => 'string',
        'password' => 'string'
    ];

    public static  $rules = [
        'name' => 'required',
        'email' => 'required',
        'role' => 'required',
        'district' => 'required_unless:role,admin',
        // 'password' => 'required'
    ];

    public static  $messages = [
        'name.required' => '氏名を入力してください',
        'email.required' => 'emailを入力してください',
        'role.required' => '種別を選択してください',
        'district.required_unless' => '地区AIS委員または地区コミッショナーは地区を選択してください',
    ];
}
