<?php

namespace App\Repositories;

use App\Models\Update;
use App\Repositories\BaseRepository;

class UpdateRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'updates_body'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Update::class;
    }
}
