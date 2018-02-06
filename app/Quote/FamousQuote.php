<?php

namespace App\Quote;

use App\Contracts\Quote;
use Unirest\Request;
use App\Category;
use App\Language;
use App\Author;
use Illuminate\Support\Facades\Log;

class FamousQuote implements Quote
{
    /**
     * Import quote from API https://andruxnet-random-famous-quotes.p.mashape.com.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $url = 'https://andruxnet-random-famous-quotes.p.mashape.com';

        $response = Request::get($url, [
            'X-Mashape-Key' => config('services.quote.key'),
        ]);

        if ($response->code == 200) {
            return [
                'author' => $response->body->author,
                'quote' => $response->body->quote,
                'category' => ucwords($response->body->category),
                'language' => 'en',
                'source' => $url,
            ];
        }

        Log::error(sprintf('Failed to get response from %s.', $url), [
            'code' => $response->code,
        ]);

        return null;
    }
}
