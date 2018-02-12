<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Quote\Poster;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app['request']->server->set('HTTPS', app()->environment('production'));

        $this->app->bind('poster', function () {
            return new Poster();
        });
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
