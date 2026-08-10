<?php

namespace Src\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Contracts\Services\DashboardServiceInterface;
use Src\Http\Resources\DashboardResource;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardServiceInterface $dashboardService
    ) {
    }

    /**
     * Display dashboard summary.
     *
     * @return DashboardResource
     */
    public function index(): DashboardResource
    {
        $record = $this->dashboardService
            // ->getDashboardSummary(auth()->id());
            ->getDashboardSummary(1);

        return new DashboardResource($record);
    }
}