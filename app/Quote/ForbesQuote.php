<?php

namespace App\Quote;

use App\Contracts\Quote;
use Unirest\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ForbesQuote implements Quote
{
    public function import(): ? array
    {
        $dir = storage_path('quotes/');
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $path = $dir.'forbes.txt';

        if (File::exists($path)) {
            $forbes = json_decode(File::get($path));
            $query = $forbes->query;
        } else {
            $query = 1;
        }

        $request = Request::get($url = 'https://www.forbes.com/forbesapi/thought/uri.json?enrich=false&query='.$query);

        if ($request->code == 200) {
            $quote = $request->body->thought;

            // increment start value when request is succeed
            File::put($path, json_encode([
                'query' => $query + 1,
            ]));

            if (!empty($quote)) {
                $category = 'Uncategorized';
                if (!empty($quote->thoughtThemes)) {
                    $category = ucwords(collect($quote->thoughtThemes)->first()->name);
                }

                return [
                    'language' => 'en',
                    'author' => $quote->thoughtAuthor->name,
                    'quote' => $quote->quote,
                    'category' => $category,
                    'source' => $quote->shortUri,
                ];
            }

            Log::warning(sprintf('Empty quote from Forbes (%s).', $url));

            return null;
        }

        Log::error(sprintf('Failed to get response from %s.', $url), [
            'code' => $request->code,
        ]);

        return null;
    }
}
