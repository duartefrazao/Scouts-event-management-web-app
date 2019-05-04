<?php

namespace App\Providers;

use App\Event;
use App\Observers\EventObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('TELESCOPE',true)) {
            $this->app->register('App\Providers\TelescopeServiceProvider');
        } 
    }
}
