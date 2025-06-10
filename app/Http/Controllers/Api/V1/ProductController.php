<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\UpdateRequest;
use App\Http\Requests\V1\Product\StoreRequest;
use App\Http\Resources\V1\Product\ProductResource;
use App\Infrastructure\Contracts\IProductContract;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(private readonly IProductContract $productService)
    {}

    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->productService->index($request->query('paginate', true)),
            config('messages.success.index')
        );
    }

    public function show(Product $product): JsonResponse
    {
        return $this->successResponse(
            ProductResource::make($product),
            config('messages.success.show')
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $store = rescue(fn () => $this->productService->store([
            'user_id' => Auth::user()->id,
            ...$request->all()
        ]));

        if (!$store) {
            return $this->errorResponse(
                config('messages.error.store'),
            );
        }

        return $this->successResponse(
            $store,
            config('messages.success.store'),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        $updated = rescue(fn() => $this->productService->update($product, $request->validated()));

        if (!$updated) {
            return $this->errorResponse(
                config('messages.error.update'),
            );
        }

        return $this->successResponse(
            $updated,
            config('messages.success.update'),
        );

    }

    public function destroy(Product $product): JsonResponse
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
