<?php

namespace App\Infrastructure\Services;

use App\Infrastructure\Contracts\ICategoryContract;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService implements ICategoryContract
{

    public function store(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function index($paginate = false): Collection | LengthAwarePaginator
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters([
                'name',
                'description',
            ])
            ->defaultSort('-id');

        if ($paginate) {
            return $categories->paginate();
        }
        return $categories->get();
    }
}
