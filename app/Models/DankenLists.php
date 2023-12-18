<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DankenLists extends Model
{
    public $table = 'danken_lists';

    public $fillable = [
        'number',
        'director',
        'place',
        'day_start',
        'day_end',
        'guidance_date',
        'deadline',
        'drive_url'
    ];

    protected $casts = [
        'id' => 'integer',
        'number' => 'integer',
        'director' => 'string',
        'place' => 'string',
        'day_start' => 'date',
        'day_end' => 'date',
        'guidance_date' => 'date',
        'deadline' => 'date',
        'drive_url' => 'string'
    ];

    public static array $rules = [
        'number' => 'required',
        'director' => 'required',
        'place' => 'required',
        'day_start' => 'required',
        'day_end' => 'required',
        'deadline' => 'required'
    ];


}
