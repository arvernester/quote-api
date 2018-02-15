<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;

class GenerateCategorySlugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slug for categories';

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
        $categories = Category::orderBy('name')->get();

        $bar = $this->output->createProgressBar($categories->count());

        foreach ($categories as $category) {
            $category->slug = null;
            $category->update(['name' => $category->name]);

            $bar->advance();
        }

        $bar->finish();
    }
}
