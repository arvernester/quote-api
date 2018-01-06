<?php

namespace App\Console\Commands\Quote;

use Illuminate\Console\Command;
use App\Contracts\Quote;

class ImportSumitgohilCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:import:sumitgohil';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import random quote from https://market.mashape.com/sumitgohil/random-quotes';

    /**
     * Quote service provider.
     *
     * @var Quote
     */
    private $quote;

    /**
     * Create a new command instance.
     */
    public function __construct(Quote $quote)
    {
        parent::__construct();

        $this->quote = $quote;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $quote = $this->quote->import();
    }
}
