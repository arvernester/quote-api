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
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $response = Request::get($host = 'https://talaikis.com/api/quotes/');

        if ($response->code == 200) {
            $quotes = [];
            foreach ($response->body as $body) {
                $quotes[] = [
                    'author' => $body->author,
                    'quote' => $body->quote,
                    'category' => ucwords($body->cat),
                    'language' => 'en',
                    'source' => $host,
                ];
            }

            return $quotes;
        }

        Log::error(sprintf('Failed to get response from %s.', $host), [
            'code' => $response->code,
        ]);

        return null;
    }
}
