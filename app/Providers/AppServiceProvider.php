<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NearService;
use App\Services\NearMe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NearService::class,NearMe::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
