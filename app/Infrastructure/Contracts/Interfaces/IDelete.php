<?php

namespace App\Infrastructure\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface IDelete
{
    public function delete(Model $model): ?bool;
}
