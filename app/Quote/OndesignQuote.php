<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use App\Quote;
use App\Author;
use App\Category;
use App\Language;

class OndesignQuote implements QuoteContract
{
    /**
     * Import quote from http://quotesondesign.com.
     *
     * @return array|null
     */
    public function import(): ? array
    {
        $response = Request::get('http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=5');

        if ($response->code == 200) {
            $quotes = [];

            foreach ($response->body as $body) {
                $sanitezedQuote = preg_replace('/(?:\s\s+|\n|\t)/', '', strip_tags($body->content));

                if (!ends_with($sanitezedQuote, ['.', '...', '?', '!'])) {
                    $sanitezedQuote .= '.';
                }

                $quotes[] = [
                    'author' => $body->title,
                    'category' => 'Uncategorized',
                    'quote' => $sanitezedQuote,
                    'language' => 'en',
                    'source' => $body->link,
                ];
            }

            return $quotes;
        }

        return null;
    }
}
