<?php

namespace App\Infrastructure\Services;

use App\Infrastructure\Contracts\Abstracts\ACrud;
use App\Models\Category;

class CategoryServices extends ACrud
{
    public function __construct()
    {
        $this->setModel(new Category());
    }
}
