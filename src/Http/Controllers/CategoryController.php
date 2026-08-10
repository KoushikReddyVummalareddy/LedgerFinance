<?php

namespace Src\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Src\Contracts\Services\CategoryServiceInterface;
use Src\Http\Requests\CategoryRequest;
use Src\Http\Requests\PaginatedIndexRequest;
use Src\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryServiceInterface $categoryService
    ) {
    }

    /**
     * Display categories.
     */
    public function index(
        PaginatedIndexRequest $request
    ): AnonymousResourceCollection {

        $records = $this->categoryService->getCategories(
            $request->getPage(),
            $request->getSize()
        );

        return CategoryResource::collection($records);
    }

    /**
     * Store category.
     */
    public function store(
        CategoryRequest $request
    ): CategoryResource {

        $record = $this->categoryService
            ->createCategory($request);

        return new CategoryResource($record);
    }

    /**
     * Update category.
     */
    public function update(
        CategoryRequest $request,
        int $id
    ): CategoryResource {

        $record = $this->categoryService
            ->updateCategory($id, $request);

        return new CategoryResource($record);
    }

    /**
     * Delete category.
     */
    public function destroy(
        int $id
    ): CategoryResource {

        $record = $this->categoryService
            ->deleteCategory($id);

        return new CategoryResource($record);
    }
}