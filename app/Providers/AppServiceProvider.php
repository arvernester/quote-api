<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app['request']->server->set('HTTPS', app()->environment('production'));
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $helpers = glob(app_path('Helpers/*'));
        foreach ($helpers as $helper) {
            include_once $helper;
        }
    }
}
