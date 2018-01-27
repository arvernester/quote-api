<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Quote\RandomQuote;
use App\Contracts\Quote;
use App\Console\Commands\Quote\ImportRandomCommand;
use App\Console\Commands\Quote\ImportFamousCommand;
use App\Quote\FamousQuote;
use App\Quote\Ondesign;
use App\Console\Commands\Quote\ImportSumitgohilCommand;
use App\Quote\SumitgohilQuote;
use App\Console\Commands\Quote\ImportOndesign;
use App\Quote\OndesignQuote;
use App\Console\Commands\Quote\ImportJagokataCommand;
use App\Quote\JagokataQuote;

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

        // Sumitgohil provider
        $this->app->when(ImportSumitgohilCommand::class)
            ->needs(Quote::class)
            ->give(function () {
                return new SumitgohilQuote();
            });

        // Ondesign provider
        $this->app->when(ImportOndesign::class)
            ->needs(Quote::class)
            ->give(function () {
                return new OndesignQuote();
            });

        // import quote from jagokata.com
        $this->app->when(ImportJagokataCommand::class)
            ->needs(Quote::class)
            ->give(function () {
                return new JagokataQuote();
            });
    }
}
