<?php

namespace App\Providers;

use App\Models\Plan;
use App\Models\Tenant;
use App\Observers\PlanObserver;
use App\Observers\TenantObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap();
        Plan::observe(PlanObserver::class);
        Tenant::observe(TenantObserver::class);
    }
}
