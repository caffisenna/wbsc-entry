<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    public $table = 'updates';

    public $fillable = [
        'updates_body'
    ];

    protected $casts = [
        'id' => 'integer',
        'updates_body' => 'string'
    ];

    public static array $rules = [
        'updates_body' => 'required'
    ];

    
}
