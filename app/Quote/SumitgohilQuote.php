<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\Log;
use App\Quote;
use App\Category;
use App\Language;
use App\Author;

class SumitgohilQuote implements QuoteContract
{
    /**
     * Import random quote from sumitgohil API.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $url = 'https://sumitgohil-random-quotes-v1.p.mashape.com/fetch/randomQuote';
        $response = Request::get($url, [
            'X-Mashape-Key' => config('services.quote.key'),
        ]);

        if ($response->code == 200) {
            $body = $response->body[0];

            // decode and remove tabs from string
            $decodedQuote = preg_replace('/\t+/', '', trim(
                mb_convert_encoding(
                    $body->quote,
                    'UTF-8',
                    'HTML-ENTITIES'
                )
            ));

            return [
                'author' => $body->author_name,
                'quote' => $decodedQuote,
                'category' => $body->category_name,
                'language' => 'en',
                'source' => $url,
            ];
        }

        Log::error(sprintf('Failed to get response from %s.'), [
            'code' => $response->code,
        ]);

        return null;
    }
}
