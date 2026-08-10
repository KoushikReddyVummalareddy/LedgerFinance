<?php

namespace Src\Providers;

use App\Providers\AppServiceProvider;
use Src\Contracts\Services\AuthServiceInterface;
use Src\Contracts\Services\CategoryServiceInterface;
use Src\Contracts\Services\DashboardServiceInterface;
use Src\Contracts\Services\TransactionServiceInterface;
use Src\Services\AuthService;
use Src\Services\CategoryService;
use Src\Services\DashboardService;
use Src\Services\TransactionService;

class FinanceServiceProvider extends AppServiceProvider
{
    /**
     * Register the application's services.
     */
    public function register(): void
    {
        parent::register();
    }

    /**
     * Bootstrap the application's services.
     */
    public function boot(): void
    {
        $this->binds();
        $this->singletons();

        parent::boot();
    }

    /**
     * Register all service bindings.
     */
    private function binds(): void
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

        $this->app->bind(
            CategoryServiceInterface::class,
            CategoryService::class
        );

        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionService::class
        );

        $this->app->bind(
            DashboardServiceInterface::class,
            DashboardService::class
        );
    }

    /**
     * Register all singleton services.
     */
    private function singletons(): void
    {
        //
    }
}