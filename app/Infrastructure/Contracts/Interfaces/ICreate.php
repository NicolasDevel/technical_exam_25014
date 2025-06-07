<?php

namespace App\Infrastructure\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ICreate
{
    public function create(array $data): Model;
}
