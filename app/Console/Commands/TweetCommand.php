<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Quote;

class TweetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto tweet';

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
        $twitter = new \Twitter(
            env('TWITTER_API_KEY'),
            env('TWITTER_API_SECRET'),
            env('TWITTER_TOKEN'),
            env('TWITTER_TOKEN_SECRET')
        );

        $quote = Quote::inRandomOrder()->first();

        if (!empty($quote)) {
            $twitter->send(sprintf('%s  ~~ %s. #DailyQuote', $quote->text, $quote->author));
        }
    }
}
