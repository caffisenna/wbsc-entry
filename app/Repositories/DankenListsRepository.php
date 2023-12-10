<?php

namespace App\Repositories;

use App\Models\DankenLists;
use App\Repositories\BaseRepository;

class DankenListsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'number',
        'director',
        'place',
        'day_start',
        'day_end',
        'guidance_date',
        'deadline',
        'drive_url'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DankenLists::class;
    }
}
