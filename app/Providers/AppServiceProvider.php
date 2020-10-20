<?php

namespace App\Providers;

use App\Services\OplabService;
use App\Services\StockTrackerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->instance(StockTrackerInterface::class, new OplabService);
    }
}
