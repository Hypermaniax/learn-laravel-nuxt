<?php

namespace App\Repositories;

use App\Models\UserModel;

class UserRepo
{
    private $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function createUser($data)
    {
        return $this->user->create($data);
    }

    public function findCredetialEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }
}
