<?php

namespace App\Console\Commands\Sitemap;

use Illuminate\Console\Command;
use App\Author;

class AuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap for author';

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

        $authors = Author::select('id', 'updated_at')
            ->orderBy('name')
            ->get();

        $sitemap = app()->make('sitemap');

        foreach ($authors as $author) {
            $sitemap->add(
                route('author.show', [$lang, $author->id]),
                $author->updated_at->toIso8601String(),
                'weekly'
            );
        }

        return $sitemap->store('xml', 'sitemap-author');
    }
}
