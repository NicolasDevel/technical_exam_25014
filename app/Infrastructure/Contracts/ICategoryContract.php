<?php

namespace App\Infrastructure\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface ICategoryContract
{
    public function store(array $data): Category;
    public function update(Category $category, array $data): bool;
    public function delete(Category $category): bool;
    public function index(): Collection | LengthAwarePaginator;
}
