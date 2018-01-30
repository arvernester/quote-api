<?php

namespace Kutip\Translation\Providers;

use Illuminate\Support\ServiceProvider;
use Kutip\Translation\YandexTranslation;
use Kutip\Translation\Contracts\Translation;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__.'/../Config/Translation.php') => config_path('translation.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(
            Translation::class,
            YandexTranslation::class
        );
    }
}
