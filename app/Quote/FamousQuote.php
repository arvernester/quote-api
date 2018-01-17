<?php

namespace App\Quote;

use App\Contracts\Quote;
use Unirest\Request;
use Illuminate\Support\Facades\Log;
use App\Quote as QuoteModel;
use App\Category;
use Illuminate\Support\Facades\DB;
use App\Language;
use App\Author;

class FamousQuote implements Quote
{
    /**
     * Import quote from API.
     *
     * @return QuoteModel
     */
    public function import(): QuoteModel
    {
        $url = 'https://andruxnet-random-famous-quotes.p.mashape.com';

        $response = Request::get($url, [
            'X-Mashape-Key' => config('services.quote.key'),
        ]);

        if ($response->code != 200) {
            Log::error($response->raw_body);
        }

        // log to debug
        Log::debug($response->raw_body);

        $existsQuote = QuoteModel::whereText($response->body->quote)
            ->with('author', 'category')
            ->first();

        if (!empty($existsQuote)) {
            Log::info(sprintf('Quote from %s is already exists.', $url), [
                'text' => $existsQuote->text,
                'author' => $existsQuote->author->name,
            ]);
        }

        if (empty($existsQuote)) {
            DB::transaction(function () use ($url, $response, &$quote) {
                $category = Category::firstOrCreate([
                    'name' => $response->body->category,
                ]);

                $language = Language::whereCode('eng')->first();

                $author = Author::firstOrCreate([
                    'name' => $response->body->author,
                ]);

                $quote = QuoteModel::create([
                    'category_id' => $category->id,
                    'language_id' => $language->id ?? null,
                    'author_id' => $author->id,
                    'text' => $response->body->quote,
                    'author' => $response->body->author,
                    'source' => $url,
                ]);
            });
        }

        return $existsQuote ?? $quote;
    }
}
