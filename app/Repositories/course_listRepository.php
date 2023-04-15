<?php

namespace App\Repositories;

use App\Models\course_list;
use App\Repositories\BaseRepository;

/**
 * Class course_listRepository
 * @package App\Repositories
 * @version April 7, 2023, 11:14 am JST
*/

class course_listRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category',
        'number',
        'director',
        'place',
        'day_start',
        'day_end',
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
        return course_list::class;
    }
}
