<?php

namespace App\Infrastructure\Contracts\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AModelBase
{
    protected Model $model;

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }
}
