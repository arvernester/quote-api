<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Quote\RandomQuote;
use App\Contracts\Quote;
use App\Console\Commands\Quote\ImportRandomCommand;
use App\Console\Commands\Quote\ImportFamousCommand;
use App\Quote\FamousQuote;

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
    public function register()
    {
        $this->app->when(ImportRandomCommand::class)
            ->needs(Quote::class)
            ->give(function () {
                return new RandomQuote();
            });

        $this->app->when(ImportFamousCommand::class)
            ->needs(Quote::class)
            ->give(function () {
                return new FamousQuote();
            });
    }
}
