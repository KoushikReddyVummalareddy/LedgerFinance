<?php

namespace Src\Services\Concerns;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

trait HasPagination
{
    /**
     * Get paginated results with soft delete filtering and eager loading.
     *
     * @param Builder $query The model query builder
     * @param int $pageNumber Page number
     * @param int $pageSize
     * @param ?bool $deleted
     * @param ?bool $pagination Whether to paginate (null defaults to true, false returns all items)
     * @param array|string|Closure $relations Relations to eager load. Can be:
     *      - String: 'relation'
     *      - Array: ['relation1', 'relation2']
     *      - Array with closures: ['relation' => function($query) { ... }]
     *
     * @return LengthAwarePaginator
     */
    protected function getPaginatedResults(
        Builder $query,
        int $pageNumber = 1,
        int $pageSize = 10,
        ?bool $deleted = null,
        ?bool $pagination = null,
        array|string|Closure $relations = []
    ): LengthAwarePaginator {
        if ($deleted === true) {
            $query->onlyTrashed();
        }

        $appendsData = [];
        if (!is_null($deleted)) {
            $appendsData['deleted'] = $deleted ? 'true' : 'false';
        }

        // Default to true if not provided
        $pagination = $pagination ?? true;

        if (!$pagination) {
            $items = $query->with($relations)->get();
            $total = $items->count();

            $paginator = new Paginator(
                $items,
                $total,
                max(1, $total),
                1,
                ['path' => request()->url(), 'pageName' => 'page']
            );

            $appendsData['pagination'] = 'false';

            return $paginator->appends($appendsData);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        $appendsData['size'] = $pageSize;

        return $query
            ->paginate($pageSize, ['*'], 'page', $pageNumber)
            ->appends($appendsData);
    }
}
