<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use Illuminate\Support\Facades\Log;
use App\Quote;
use Illuminate\Support\Facades\DB;
use App\Category;

class SumitgohilQuote implements QuoteContract
{
    /**
     * Import random quote from sumitgohil API.
     *
     * @return Quote|null
     */
    public function import(): ? Quote
    {
        $url = 'https://sumitgohil-random-quotes-v1.p.mashape.com/fetch/randomQuote';
        $response = Request::get($url, [
            'X-Mashape-Key' => config('services.quote.key'),
        ]);

        if ($response->code !== 200) {
            Log::error($response->raw_body);

            return null;
        }

        if (empty($response->body[0])) {
            Log::error(sprintf('Quote from %s is empty', $url));

            return null;
        }

        $body = $response->body[0];

        // decode and remove tabs from string
        $decodedQuote = preg_replace('/\t+/', '', trim(
            mb_convert_encoding(
                $body->quote,
                'UTF-8',
                'HTML-ENTITIES'
            )
        ));

        $existsQuote = Quote::whereText($decodedQuote)
            ->whereAuthor($body->author_name)
            ->first();

        if (!empty($existsQuote)) {
            Log::info(sprintf('Quote from %s is already exists', $url), [
                'text' => $decodedQuote,
                'author' => $body->author_name,
            ]);

            return $existsQuote;
        }

        Log::debug(json_encode($body));

        DB::transaction(function () use ($url, $body, $decodedQuote, &$quote) {
            $category = Category::firstOrCreate([
                'name' => $body->category_name,
            ]);

            $quote = Quote::create([
                'category_id' => $category->id,
                'text' => $decodedQuote,
                'author' => $body->author_name,
                'source' => $url,
            ]);
        });

        return $quote ?? null;
    }
}
