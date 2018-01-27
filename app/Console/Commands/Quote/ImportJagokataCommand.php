<?php

namespace App\Console\Commands\Quote;

use App\Contracts\Quote as QuoteContract;
use Illuminate\Console\Command;

class ImportJagokataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:import:jagokata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import random quote from jagokata.com';

    /**
     * Quote contract.
     *
     * @var Quote
     */
    private $quote;

    /**
     * Create a new command instance.
     */
    public function __construct(QuoteContract $quote)
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
