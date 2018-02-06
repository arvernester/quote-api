<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Goutte\Client;
use App\Language;
use App\Category;
use App\Quote;
use App\Author;

class JagokataQuote implements QuoteContract
{
    /**
     * Import quotes from jagokata.com.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $client = new Client();

        $response = $client->request('GET', $host = 'https://jagokata.com/kutipan/acak.html');

        $quotes = [];

        $response->filter('ul#citatenrijen > li')->each(function ($node) use (&$quotes, $host) {
            if ($node->attr('id') != 'googleinpage') {
                $author = $node->filter('div.citatenlijst-auteur-container > div.citatenlijst-auteur > a')->first()->text();
                $quote = $node->filter('p.fbquote')->first()->text();

                $quotes[] = [
                    'author' => $author,
                    'quote' => $quote,
                    'category' => 'Uncategorized',
                    'language' => 'id',
                    'source' => $host,
                ];
            }
        });

        return $quotes ?? null;
    }
}
