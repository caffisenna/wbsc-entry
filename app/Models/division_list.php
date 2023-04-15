<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class division_list
 * @package App\Models
 * @version April 15, 2023, 2:32 pm JST
 *
 * @property string $division
 * @property string $number
 * @property string $director
 * @property string $place
 * @property string $day_start
 * @property string $guidance_date
 * @property string $deadline
 */
class division_list extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'division_lists';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'division',
        'number',
        'director',
        'place',
        'day_start',
        'guidance_date',
        'deadline'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'division' => 'string',
        'number' => 'string',
        'director' => 'string',
        'place' => 'string',
        'day_start' => 'date',
        'guidance_date' => 'date',
        'deadline' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'division' => 'required',
        'number' => 'required',
        'director' => 'required',
        'place' => 'required',
        'day_start' => 'required',
        'deadline' => 'required'
    ];


}
