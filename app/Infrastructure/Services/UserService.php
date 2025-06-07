<?php

namespace App\Infrastructure\Services;


use App\Infrastructure\Contracts\IUserContract;
use App\Models\User;

class UserService implements IUserContract
{
    public function create(array $data): User
    {
        return User::create($data);
    }
}
