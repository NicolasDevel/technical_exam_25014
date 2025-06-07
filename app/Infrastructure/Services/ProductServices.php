<?php

namespace App\Infrastructure\Services;

use App\Infrastructure\Contracts\Abstracts\ACrud;
use App\Models\Product;

class ProductServices extends ACrud
{
    public function __construct()
    {
        $this->setModel(new Product());
    }
}
