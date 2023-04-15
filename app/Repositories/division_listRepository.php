<?php

namespace App\Repositories;

use App\Models\division_list;
use App\Repositories\BaseRepository;

/**
 * Class division_listRepository
 * @package App\Repositories
 * @version April 15, 2023, 2:32 pm JST
*/

class division_listRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'division',
        'number',
        'director',
        'place',
        'day_start',
        'guidance_date',
        'deadline'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return division_list::class;
    }
}
