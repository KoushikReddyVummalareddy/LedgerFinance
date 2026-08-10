<?php

namespace Src\Contracts\Services;

interface DashboardServiceInterface
{
    /**
     * Get dashboard summary.
     *
     * @param int $userId
     * @return array
     */
    public function getDashboardSummary(
        int $userId
    ): array;
}