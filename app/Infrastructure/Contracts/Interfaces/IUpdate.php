<?php

namespace App\Infrastructure\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface IUpdate
{
    public function update(Model $model, array $data): Model;
}
