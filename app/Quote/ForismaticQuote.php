<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\Log;

class ForismaticQuote implements QuoteContract
{
    /**
     * Get quote from forismatic.com.
     */
    public function import(): ? array
    {
        $lang = 'en';
        $response = Request::get($url = 'http://api.forismatic.com/api/1.0/?method=getQuote&format=json&lang='.$lang);

        if ($response->code == 200) {
            return [
                'language' => $lang,
                'author' => trim($response->body->quoteAuthor),
                'quote' => trim($response->body->quoteText),
                'source' => $response->body->quoteLink,
                'category' => 'Uncategorized',
            ];
        }

        Log::error(sprintf('Failed to get response from %s.', $url), [
            'code' => $response->code,
        ]);

        return null;
    }
}
