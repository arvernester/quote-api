<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Quote\RandomQuote;
use App\Contracts\Quote as QuoteContract;
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
        $vendor = config('services.quote.vendor');

        $implements = [
            'random' => RandomQuote::class,
            'famous' => FamousQuote::class,
        ];

        if (array_key_exists($vendor, $implements)) {
            $this->app->bind(
                QuoteContract::class,
                $implements[$vendor]
            );
        }
    }
}
