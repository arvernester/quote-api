<?php

namespace App\Console\Commands\Quote;

use Illuminate\Console\Command;
use App\Contracts\Quote;

class ImportFamousCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:import:famous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import famous quote from https://market.mashape.com/andruxnet/random-famous-quotes';

    /**
     * Quote contract.
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
        $this->quote->import();
        // $this->line('Famous quote has been imported.');
    }
}
