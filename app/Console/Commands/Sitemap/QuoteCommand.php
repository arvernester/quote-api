<?php

namespace App\Console\Commands\Sitemap;

use Illuminate\Console\Command;
use App\Quote;

class QuoteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:quote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap for quotes';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lang = config('app.locale');

        $quotes = Quote::select('id', 'updated_at')
            ->orderBy('created_at')
            ->get();

        $sitemap = app()->make('sitemap');

        foreach ($quotes as $quote) {
            $sitemap->add(
                route('quote.show', [$lang, $quote]),
                $quote->updated_at->toIso8601String(),
                'weekly'
            );
        }

        return $sitemap->store('xml', 'sitemap-quote');
    }
}
