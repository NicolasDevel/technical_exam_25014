<?php

namespace App\Infrastructure\Services;

use App\Infrastructure\Contracts\IProductContract;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductService implements IProductContract
{

    public function store(array $data): Product
    {
        return Product::create([
            'user_id' => Auth::user()->id,
            ...$data
        ]);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update([$data]);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function index(bool $paginate = false): Collection|LengthAwarePaginator
    {
        $query = QueryBuilder::for(Product::class)
            ->allowedFilters([
                AllowedFilter::exact('category_id'),
                'name',
                'description',
                AllowedFilter::callback('min_price', fn ($query, $value) =>
                  $query->where('price', '>=', $value)
                ),
                AllowedFilter::callback('max_price', fn ($query, $value) =>
                    $query->where('price', '<=', $value)
                ),
                AllowedFilter::callback('min_stock', fn ($query, $value) =>
                    $query->where('stock', '>=', $value)
                ),
                AllowedFilter::callback('max_stock', fn ($query, $value) =>
                    $query->where('stock', '<=', $value)
                ),
            ])
            ->defaultSort('-id');

        if ($paginate) {
            return $query->paginate();
        }

        return $query->get();
    }
}
