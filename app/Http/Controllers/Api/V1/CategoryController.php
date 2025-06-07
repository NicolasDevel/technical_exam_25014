<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Category\StoreRequest;
use App\Http\Requests\V1\Category\UpdateRequest;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Infrastructure\Contracts\ICategoryContract;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(private readonly ICategoryContract $categoryService)
    {}

    public function index(Request $request)
    {
        return $this->successResponse(
            $this->categoryService->index($request->query('paginate', true)),
            config('messages.success.index')
        );
    }

    public function show(Category $category)
    {
        return $this->successResponse(
            CategoryResource::make($category),
            config('messages.success.show'),
        );
    }

    public function store(StoreRequest $request)
    {
        $store = rescue(fn () => $this->categoryService->store($request->validated()));

        if (!$store) {
            return $this->errorResponse(
                config('messages.error.store'),
            );
        }

        return $this->successResponse(
            CategoryResource::make($store),
            config('messages.success.store'),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $updated = rescue(fn() => $this->categoryService->update($category, $request->validated()));

        if (!$updated) {
            return $this->errorResponse(
                config('messages.error.update'),
            );
        }

        return $this->successResponse(
            CategoryResource::make($category),
            config('messages.success.update'),
        );

    }

    public function destroy(Category $category)
    {
        $delete = rescue(fn() => $this->categoryService->delete($category));
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
