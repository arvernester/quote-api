<?php

namespace App\Console\Commands\Quote;

use Illuminate\Console\Command;
use App\Contracts\Quote;

class ImportOndesign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:import:ondesign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import quote from http://quotesondesign.com';

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
    }
}
