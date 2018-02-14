<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\Quote as QuoteContract;
use App\Author;
use App\Category;
use App\Language;
use App\Quote;
use Illuminate\Support\Facades\DB;

class ImportQuoteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:import {--vendor=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import command from various vendors';

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
        $vendor = trim($this->option('vendor'));

        $quote = app()->makeWith(QuoteContract::class, ['vendor' => $vendor]);

        $import = $quote->import();

        if (!empty($import)) {
            if (!empty($import) and !isset($import[0])) {
                DB::transaction(function () use ($import) {
                    $this->store(
                        $import['author'],
                        $import['category'],
                        $import['quote'],
                        $import['language'],
                        $import['source']
                    );
                });
            } else {
                $quotes = [];
                foreach ($import as $i) {
                    $quotes[] = $this->store(
                        $i['author'],
                        $i['category'],
                        $i['quote'],
                        $i['language'],
                        $i['source']
                    );
                }
            }
        }
    }

    /**
     * Store new quote into database.
     *
     * @param string      $author
     * @param string|null $category
     * @param string      $text
     * @param string      $lang
     * @param string|null $source
     *
     * @return Quote
     */
    private function store(string $author, ?string $category, string $text, string $lang, ? string $source = null): Quote
    {
        DB::transaction(function () use (
            &$quote,
            $author,
            $category,
            $text,
            $lang,
            $source
        ) {
            $author = Author::firstOrCreate([
                'name' => $author,
            ]);

            $category = Category::firstOrCreate([
                'name' => $category ?? 'Uncategorized',
            ]);

            // get language
            $language = Language::where('code_alternate', $lang)->first();

            $quote = Quote::firstOrNew([
                'text' => $text,
            ]);

            $quote->author_id = $author->id;
            $quote->language_id = $language->id ?? null;
            $quote->category_id = $category->id;
            $quote->slug = str_slug($author->name);
            $quote->source = $source ?? null;
            $quote->save();
        });

        return $quote;
    }
}
