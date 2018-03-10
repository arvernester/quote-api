<?php

namespace App\Quote;

use App\Contracts\Quote;
use Unirest\Request;
use Illuminate\Support\Facades\Log;

class FavqsQuote implements Quote
{
    /**
     * Import quote of the day from https://favqs.com/api/qotd.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $request = Request::get($url = 'https://favqs.com/api/qotd');

        if ($request->code == 200) {
            $quote = $request->body->quote;

            if (!empty($quote)) {
                $category = 'Uncategorized';
                if (!empty($quote->tags)) {
                    $category = ucwords(collect($quote->tags)->first());
                }

                return [
                    'author' => $quote->author,
                    'quote' => $quote->body,
                    'category' => $category,
                    'language' => 'en',
                    'source' => $quote->url,
                ];
            }

            Log::warning(sprintf('Empty quote from Favqs (%s).', $url));

            return null;
        }

        Log::error(sprintf('Failed to get response from %s.', $url), [
            'code' => $response->code,
        ]);

        return null;
    }
}
