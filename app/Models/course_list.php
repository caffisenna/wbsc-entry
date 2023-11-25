<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class course_list
 * @package App\Models
 * @version April 7, 2023, 11:14 am JST
 *
 * @property string $category
 * @property string $number
 * @property string $director
 * @property string $place
 * @property string $day_start
 * @property string $day_end
 * @property string $guidance_date
 * @property string $deadline
 * @property string $drive_url
 */
class course_list extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'course_lists';


    protected $dates = ['deleted_at'];



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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'director' => 'string',
        'place' => 'string',
        'day_start' => 'date',
        'day_end' => 'date',
        'guidance_date' => 'date',
        'deadline' => 'date',
        'drive_url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'number' => 'required',
        'director' => 'required',
        'place' => 'required',
        'day_start' => 'required',
        'day_end' => 'required_if:category,sc', // SCの場合は必須
        'guidance_date' => 'required',
        'deadline' => 'required'
    ];


}
