<?php

namespace Src\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Contracts\Services\CategoryServiceInterface;
use Src\Http\Requests\CategoryRequest;
use Src\Models\Category;
use Src\Services\Concerns\HasPagination;

class CategoryService implements CategoryServiceInterface
{
    use HasPagination;

    public function createCategory(
        CategoryRequest $request
    ): Category {
        $category = new Category();

        $category->name = $request->name;
        $category->type = $request->type;

        $category->save();

        return $category;
    }

    public function updateCategory(
        int $id,
        CategoryRequest $request
    ): Category {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->type = $request->type;

        $category->save();

        return $category;
    }

    public function getCategories(
        int $pageNumber = 1,
        int $pageSize = 10
    ): LengthAwarePaginator {
        return $this->getPaginatedResults(
            Category::query()->orderByDesc('created_at'),
            $pageNumber,
            $pageSize
        );
    }

    public function getCategoryById(
        int $id
    ): Category {
        return Category::findOrFail($id);
    }

    public function deleteCategory(
        int $id
    ): Category {
        $category = Category::findOrFail($id);

        $category->delete();

        return $category;
    }
}