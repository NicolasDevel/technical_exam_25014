<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\UpdateRequest;
use App\Http\Requests\V1\Product\StoreRequest;
use App\Http\Resources\V1\Product\ProductResource;
use App\Infrastructure\Contracts\IProductContract;
use App\Infrastructure\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(private readonly IProductContract $productService)
    {}

    public function index(Request $request)
    {
        return $this->successResponse(
            $this->productService->index($request->query('paginate', true)),
            config('messages.success.index')
        );
    }

    public function show(Product $product)
    {
        return $this->successResponse(
            ProductResource::make($product),
            config('messages.success.show')
        );
    }

    public function store(StoreRequest $request)
    {
        $store = rescue(fn () => $this->productService->store($request->validated()));

        if (!$store) {
            return $this->errorResponse(
                config('messages.error.store'),
            );
        }

        return $this->successResponse(
            ProductResource::make($store),
            config('messages.success.store'),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $updated = rescue(fn() => $this->productService->update($product, $request->validated()));

        if (!$updated) {
            return $this->errorResponse(
                config('messages.error.update'),
            );
        }

        return $this->successResponse(
            ProductResource::make($product),
            config('messages.success.update'),
        );

    }

    public function destroy(Product $product)
    {
        $delete = rescue(fn() => $this->productService->delete($product));
        if (!$delete) {
            return $this->errorResponse(
                config('messages.error.delete'),
            );
        }
        return $this->successResponse(
            [],
            config('messages.success.delete'),
        );
    }
}
