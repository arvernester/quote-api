<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Quote;
use Illuminate\Support\Facades\Log;
use App\Language;
use App\Author;

class RandomQuote implements QuoteContract
{
    /**
     * Import random quote from API.
     */
    public function import(): ? Quote
    {
        $response = Request::get($url = 'https://quotes.p.mashape.com/', [
            'X-MASHAPE-KEY' => config('services.quote.key'),
        ]);

        if ($response->code == 200) {
            Log::debug($response->raw_body);

            $existsQuote = Quote::whereText($response->body->quote)
                ->with('author', 'category')
                ->first();

            // inform quote has been added before
            if (!empty($existsQuote)) {
                Log::info(sprintf('Quote from %s is already exists.', $url), [
                    'text' => $existsQuote->text,
                    'author' => $existsQuote->author->name,
                ]);

                return $existsQuote;
            }

            DB::transaction(function () use ($url, $response, &$quote) {
                $category = Category::firstOrCreate([
                    'name' => ucwords($response->body->category),
                ]);

                $language = Language::whereCode('eng')->first();

                $author = Author::firstOrCreate([
                    'name' => $response->body->author,
                ]);

                $quote = Quote::create([
                    'category_id' => $category->id,
                    'language_id' => $language->id ?? null,
                    'author_id' => $author->id,
                    'text' => $response->body->quote,
                    'author' => $response->body->author,
                    'source' => $url,
                ]);
            });
        }

        return $quote ?? null;
    }
}
