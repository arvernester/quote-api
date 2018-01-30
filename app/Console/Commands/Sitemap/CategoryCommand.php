<?php

namespace App\Console\Commands\Sitemap;

use Illuminate\Console\Command;
use App\Category;

class CategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap for category';

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

        $categories = Category::select('id', 'updated_at')
            ->orderBy('name')
            ->get();

        $sitemap = app()->make('sitemap');

        foreach ($categories as $category) {
            $sitemap->add(
                route('category.show', [$lang, $category]),
                $category->updated_at->toIso8601String(),
                'weekly'
            );
        }

        return $sitemap->store('xml', 'sitemap-category');
    }
}
