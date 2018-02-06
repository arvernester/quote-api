<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Quote;

class QuoteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register($vendor = null)
    {
        $this->app->bind(Quote::class, function ($app, $params) {
            if (empty($params['vendor'])) {
                $params['vendor'] = 'Programming';
            }
            $class = '\\App\\Quote\\'.studly_case($params['vendor']).'Quote';

            abort_if(!class_exists($class), 500, sprintf('Class %s is not exists.', $class));

            return new $class();
        });
    }
}
