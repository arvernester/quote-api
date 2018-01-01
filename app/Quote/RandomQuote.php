<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Quote;

class RandomQuote implements QuoteContract
{
    public function import()
    {
        $response = Request::get($url = 'https://quotes.p.mashape.com/', [
            'X-MASHAPE-KEY' => config('services.quote.key'),
        ]);

        $quote = Quote::whereText($response->body->quote)->first();

        if (empty($quote)) {
            DB::transaction(function () use ($url, $response, &$quote) {
                $category = Category::firstOrCreate([
                    'name' => ucwords($response->body->category),
                ]);

                $quote = Quote::create([
                    'category_id' => $category->id,
                    'text' => $response->body->quote,
                    'author' => $response->body->author,
                    'source' => $url,
                ]);
            });
        }

        $quote->load('category');

        return $quote;
    }
}
