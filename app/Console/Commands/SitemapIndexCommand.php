<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GeneralNotification;
use App\User;

class SitemapIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap index';

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
        $sitemap = app()->make('sitemap');

        // create subdirectory
        $sitemapDir = public_path($subDir = 'sitemap/');
        if (!File::isDirectory($sitemapDir)) {
            File::makeDirectory($sitemapDir, 0777, true);
        }

        $categories = Category::orderBy('name')
            ->get();

        $bar = $this->output->createProgressBar($categories->count());

        $sitemap = app()->make('sitemap');

        foreach ($categories as $category) {
            $category->load('quotes');

            $sitemapPost = app()->make('sitemap');
            foreach ($category->quotes as $quote) {
                $sitemapPost->add(
                    route_lang('quote.show', $quote),
                    $quote->updated_at->toIso8601String(),
                    '0.8',
                    'weekly',
                    [
                        [
                            'url' => route('quote.poster', $quote),
                            'caption' => $caption = __('Quote by :author', [
                                'author' => $quote->author->name,
                            ]),
                            'title' => $caption,
                        ],
                    ]
                );
            }

            $sitemapPost->store('xml', $path = $subDir.str_slug($category->name));
            unset($sitemapPost);

            $bar->advance();

            $sitemap->addSitemap(
                url($path.'.xml'),
                $category->updated_at->toIso8601String()
            );
        }

        $sitemap->store('sitemapindex', 'sitemap');

        $bar->finish();

        $users = User::all();
        Notification::send($users, new GeneralNotification(
            __('Sitemap index has been generated'),
            '',
            'fa-sitemap'
        ));

        $this->info(PHP_EOL.__('Sitemap has been generated.'));
    }
}
