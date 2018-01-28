<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\Log;
use App\Quote;
use App\Author;
use App\Category;
use App\Language;

class TalaikisQuote implements QuoteContract
{
    /**
     * Import 100 random quotes from talaikis.com.
     */
    public function import()
    {
        $response = Request::get($host = 'https://talaikis.com/api/quotes/');

        if ($response->code == 200) {
            $language = Language::whereCode('eng')->first();

            foreach ($response->body as $body) {
                Log::debug(json_encode($body));

                if (!ends_with($body->quote, ['.', '...', '?', '!'])) {
                    $body->quote .= '.';
                }

                $exists = Quote::whereText($body->quote)->first();

                if ($exists) {
                    Log::info(sprintf('Quote from %s is already exists.', $host), [
                        'quote' => $body->quote,
                        'author' => $body->author,
                    ]);
                } else {
                    $author = Author::firstOrCreate([
                        'name' => $body->author,
                    ]);

                    $category = Category::firstOrCreate([
                        'name' => ucwords($body->cat),
                    ]);

                    $quote = Quote::create([
                        'category_id' => $category->id,
                        'author_id' => $author->id,
                        'language_id' => $language->id,
                        'text' => $body->quote,
                        'source' => $host,
                    ]);
                }
            }
        } else {
            Log::error('Failed to send request to '.$host);
        }
    }
}
