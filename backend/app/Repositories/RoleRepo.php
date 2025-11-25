<?php

namespace App\Repositories;

use App\Models\RoleModel;

class RoleRepo
{
    public $role;

    public function __construct(RoleModel $role)
    {
        $this->role = $role;
    }

    public function createRole($data)
    {
       return $this->role->create($data);
    }
}
