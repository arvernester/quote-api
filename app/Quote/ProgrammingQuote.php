<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\Log;

class ProgrammingQuote implements QuoteContract
{
    /**
     * Import programming quote from http://quotes.stormconsultancy.co.uk/api.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $response = Request::get('http://quotes.stormconsultancy.co.uk/random.json');

        if ($response->code == 200) {
            return [
                'author' => $response->body->author,
                'quote' => $response->body->quote,
                'category' => 'Programming',
                'language' => 'en',
                'source' => $response->body->permalink,
            ];
        }

        Log::error('Failed to get response from http://quotes.stormconsultancy.co.uk/random.json.', [
            'code' => $response->code,
        ]);

        return null;
    }
}
