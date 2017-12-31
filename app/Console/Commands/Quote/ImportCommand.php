<?php

namespace App\Console\Commands\Quote;

use Illuminate\Console\Command;
use Unirest\Request as Unirest;
use Illuminate\Support\Facades\Log;
use App\Category;
use App\Quote;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import famous and movies quote from API';

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
        $quote = Unirest::get(config('services.quote.url'), [
            'X-Mashape-Key' => config('services.quote.key'),
        ]);

        if ($quote->code != 200) {
            Log::error($quote->body->message);
        }

        $category = Category::firstOrCreate([
            'name' => $quote->body->category,
        ]);

        $quote = Quote::create([
            'category_id' => $category->id,
            'user_id' => null,
            'text' => $quote->body->quote,
            'author' => $quote->body->author,
            'source' => config('services.quote.url'),
        ]);

        return response()->json($quote);
    }
}
