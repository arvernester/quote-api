<?php

namespace App\Quote;

use App\Contracts\Quote as QuoteContract;
use Unirest\Request;
use App\Quote;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Author;
use App\Category;
use App\Language;

class OndesignQuote implements QuoteContract
{
    /**
     * Import quote from http://quotesondesign.com.
     */
    public function import(): bool
    {
        $response = Request::get('http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=5');

        if ($response->code == 200) {
            foreach ($response->body as $body) {
                $sanitezedQuote = preg_replace('/(?:\s\s+|\n|\t)/', '', strip_tags($body->content));
                $exists = Quote::whereText($sanitezedQuote)
                    ->with('author')
                    ->first();

                if (!empty($exists)) {
                    Log::info('Quote from Ondesign is already exists.', [
                        'text' => $exists->text,
                        'author' => $exists->author->name,
                    ]);

                    return false;
                }

                DB::transaction(function () use ($body, $sanitezedQuote) {
                    $author = Author::firstOrCreate([
                        'name' => $body->title,
                    ]);

                    $category = Category::firstOrCreate([
                        'name' => 'Uncategorized',
                    ]);

                    $language = Language::whereCode('eng')->first();

                    $quote = Quote::create([
                        'category_id' => $category->id,
                        'language_id' => $language->id,
                        'author_id' => $author->id,
                        'text' => $sanitezedQuote,
                        'source' => $body->link ?? null,
                    ]);
                });
            }

            return true;
        }
    }
}
