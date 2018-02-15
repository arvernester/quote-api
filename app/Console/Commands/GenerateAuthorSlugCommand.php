<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Author;

class GenerateAuthorSlugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slug for authors';

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
        $bar = $this->output->createProgressBar(Author::count());
        $authors = Author::orderBy('name')->chunk(1000, function ($authors) use ($bar) {
            foreach ($authors as $author) {
                $author->slug = null;
                $author->update(['name' => $author->name]);

                $bar->advance();
            }
        });

        $bar->finish();
    }
}
