<?php

namespace App\Repositories;

use App\Models\Entry_info;
use App\Repositories\BaseRepository;

/**
 * Class Entry_infoRepository
 * @package App\Repositories
 * @version October 15, 2022, 10:45 pm JST
*/

class Entry_infoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'furigana',
        'gender',
        'bs_id',
        'prefecture',
        'district',
        'dan',
        'troop',
        'troop_role',
        'cell_phone',
        'zip',
        'address',
        'district_role',
        'prefecture_role',
        'scout_camp',
        'bs_basic_course',
        'wb_basic1_category',
        'wb_basic1_number',
        'wb_basic1_date',
        'wb_adv1_category',
        'wb_adv1_number',
        'wb_adv1_date',
        'service_hist1_role',
        'service_hist1_term',
        'health_illness',
        'health_memo',
        'commi_checked_at',
        'ais_checked_at',
        'gm_checked_at'
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
        return Entry_info::class;
    }
}
