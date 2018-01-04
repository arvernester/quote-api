<?php

namespace App\Console\Commands\Quote;

use Illuminate\Console\Command;
use Unirest\Request as Unirest;
use Illuminate\Support\Facades\Log;
use App\Category;
use App\Quote;
use Illuminate\Support\Facades\DB;

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
        $response = Unirest::get($url = config('services.quote.url'), [
            'X-Mashape-Key' => config('services.quote.key'),
        ]);

        if ($response->code != 200) {
            Log::error($response->raw_body);
        }

        // log to debug
        Log::debug($response->raw_body);

        $existsQuote = Quote::whereText($response->body->quote)
            ->with('category')
            ->first();

        if (!empty($existsQuote)) {
            Log::info(sprintf('Quote from %s is already exists.', $url), [
                'text' => $existsQuote->text,
                'author' => $existsQuote->author,
            ]);
        }

        if (empty($existsQuote)) {
            DB::transaction(function () use ($response, &$quote) {
                $category = Category::firstOrCreate([
                    'name' => $response->body->category,
                ]);

                $quote = Quote::create([
                    'category_id' => $category->id,
                    'text' => $response->body->quote,
                    'author' => $response->body->author,
                    'source' => $url,
                ]);
            });
        }

        return response()->json($existsQuote ?? $quote);
    }
}
