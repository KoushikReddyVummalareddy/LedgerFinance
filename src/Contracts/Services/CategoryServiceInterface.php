<?php

namespace Src\Contracts\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Http\Requests\CategoryRequest;
use Src\Models\Category;

interface CategoryServiceInterface
{
    /**
     * Get all categories.
     *
     * @param int $pageNumber
     * @param int $pageSize
     * @return LengthAwarePaginator
     */
    public function getCategories(
        int $pageNumber = 1,
        int $pageSize = 10
    ): LengthAwarePaginator;

    /**
     * Get category by id.
     *
     * @param int $id
     * @return Category
     */
    public function getCategoryById(
        int $id
    ): Category;

    /**
     * Create category.
     *
     * @param CategoryRequest $request
     * @return Category
     */
    public function createCategory(
        CategoryRequest $request
    ): Category;

    /**
     * Update category.
     *
     * @param int $id
     * @param CategoryRequest $request
     * @return Category
     */
    public function updateCategory(
        int $id,
        CategoryRequest $request
    ): Category;

    /**
     * Delete category.
     *
     * @param int $id
     * @return Category
     */
    public function deleteCategory(
        int $id
    ): Category;
}