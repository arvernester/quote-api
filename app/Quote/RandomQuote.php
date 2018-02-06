<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use App\Category;
use App\Quote;
use App\Language;
use App\Author;

class RandomQuote implements QuoteContract
{
    /**
     * Import random quote from API.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $response = Request::get($url = 'https://quotes.p.mashape.com/', [
            'X-MASHAPE-KEY' => config('services.quote.key'),
        ]);

        if ($response->code == 200) {
            return [
                'author' => $response->body->author,
                'category' => ucwords($response->body->category),
                'quote' => $response->body->quote,
                'language' => 'en',
                'source' => $url,
            ];
        }

        return null;
    }
}
