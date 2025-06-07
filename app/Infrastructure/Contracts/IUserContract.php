<?php

namespace App\Infrastructure\Contracts;

use App\Models\User;

interface IUserContract
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User;
}
