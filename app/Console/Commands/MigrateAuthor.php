<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Quote;
use App\Author;

class MigrateAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate author data from quotes table';

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
        $quotes = Quote::orderBy('author', 'ASC')
            ->get();

        $bar = $this->output->createProgressBar($quotes->count());

        foreach ($quotes as $quote) {
            $author = Author::firstOrCreate([
                'name' => $quote->author,
            ]);

            $quote->fill(['author_id' => $author->id]);
            $quote->save();

            $bar->advance();
        }

        $bar->finish();

        $this->info(sprintf(PHP_EOL.'Total %s authors has been migrated to new table.', $quotes->count()));
    }
}
