<?php

namespace App\Infrastructure\Contracts\Abstracts;

use App\Infrastructure\Contracts\Interfaces\ICreate;
use App\Infrastructure\Contracts\Interfaces\IDelete;
use App\Infrastructure\Contracts\Interfaces\IUpdate;
use Illuminate\Database\Eloquent\Model;

abstract class ACrud extends AModelBase implements ICreate, IUpdate, IDelete
{
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }
}
