<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Quote;

class GenerateQuoteSlugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slug for quote';

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
        $bar = $this->output->createProgressBar(Quote::count());

        Quote::orderBy('id')->chunk(1000, function ($quotes) use ($bar) {
            foreach ($quotes as $quote) {
                $quote->slug = str_slug($quote->author->name);
                $quote->save();

                $bar->advance();
            }
        });

        $bar->finish();
    }
}
