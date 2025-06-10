<?php

namespace App\Infrastructure\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IProductContract
{
    public function store(array $data): Product;
    public function update(Product $product, array $data): bool;
    public function delete(Product $product): bool;
    public function index(bool $paginate = false): Collection | LengthAwarePaginator;
}
