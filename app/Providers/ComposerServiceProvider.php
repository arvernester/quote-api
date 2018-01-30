<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Composers\NotificationComposer;
use App\Composers\LanguageComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        View::composer(
            'layouts.partials.notification',
            NotificationComposer::class
        );

        View::composer(
            '*',
            LanguageComposer::class
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
