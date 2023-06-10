<?php

namespace App\Repositories;

use App\Models\add_user;
use App\Repositories\BaseRepository;

class add_userRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'email',
        'role',
        'district',
        'password'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return add_user::class;
    }
}
