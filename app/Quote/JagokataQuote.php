<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use App\Language;
use App\Category;
use App\Quote;
use App\Author;
use Illuminate\Support\Facades\Log;

class JagokataQuote implements QuoteContract
{
    public function import()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://jagokata.com/kutipan/acak.html');

        $quotes = [];

        $response->filter('ul#citatenrijen > li')->each(function ($node) use (&$quotes) {
            if ($node->attr('id') != 'googleinpage') {
                $author = $node->filter('div.citatenlijst-auteur-container > div.citatenlijst-auteur > a')->first()->text();
                $quote = $node->filter('p.fbquote')->first()->text();

                $quotes[] = [
                    'quote' => $quote,
                    'author' => $author,
                ];
            }
        });

        DB::transaction(function () use ($quotes) {
            $language = Language::whereCode('ind')->first();
            $category = Category::firstOrCreate(['name' => 'Uncategorized']);

            foreach ($quotes as $quote) {
                if (!ends_with($quote['quote'], ['.', '...', '?', '!'])) {
                    $quote['quote'] .= '.';
                }

                $existsQuote = Quote::whereText($quote['quote'])->first();

                if (empty($existsQuote)) {
                    $author = Author::firstOrCreate(['name' => $quote['author']]);

                    $stored = Quote::create([
                        'language_id' => $language->id,
                        'category_id' => $category->id,
                        'author_id' => $author->id,
                        'text' => $quote['quote'],
                        'source' => 'https://jagokata.com',
                    ]);
                } else {
                    Log::info('Quote from jagokata.com is already exists.', [
                        'quote' => $quote['quote'],
                        'author' => $quote['author'],
                    ]);
                }
            }
        });
    }
}
