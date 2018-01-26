<?php

namespace App\Console\Commands\Quote;

use Illuminate\Console\Command;
use App\Quote;
use Illuminate\Support\Facades\DB;
use App\Language;

class TweetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:tweet {--lang=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto tweet random quote as daily quote';

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

        DB::transaction(function () use (&$quote) {
            $lang = $this->option('lang');

            if (Language::whereCode($lang)->count() <= 0) {
                $this->error(sprintf('Language "%s" is not exists.', $lang));
                exit;
            }

            $quote = Quote::inRandomOrder()
                ->when($lang, function ($query) use ($lang) {
                    return $query->whereHas('language', function ($language) use ($lang) {
                        return $language->whereCode($lang);
                    });
                })
                ->first();
        });

        if (!empty($quote)) {
            if (env('TWITTER_HASHTAG')) {
                $hashtags = [];
                foreach (explode(',', env('TWITTER_HASHTAG')) as $tag) {
                    $hashtags[] = '#'.$tag;
                }
            }
            $twitter->send(sprintf('%s  ~~ %s. %s', $quote->text, $quote->author->name, implode(' ', $hashtags) ?? '#Quote'));
        }
    }
}
