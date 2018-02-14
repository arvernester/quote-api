<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Quote\Poster;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

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

        // remove line below when using Bootsrap version 4
        Paginator::useBootstrapThree();

        Validator::extend('has_column', function ($attribute, $value, $params, $validator) {
            if (empty($params[0])) {
                // table name must be defined
                return false;
            }

            return Schema::hasColumn($params[0], $value);
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
