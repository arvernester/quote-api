<?php

namespace App\Http\Controllers;

use App\Quote;

class ShareController extends Controller
{
    /**
     * Share quote to twitter.
     *
     * @param Quote $quote
     */
    public function twitter(Quote $quote)
    {
        $quote->load('author');

        $tweet = sprintf(
            '%s By %s. Via @%s.',
            $quote->text,
            $quote->author->name,
            env('TWITTER_USERNAME')
        );

        abort_if(strlen($tweet) > 280, 500, 'Tweet character is too long.');

        return redirect('https://twitter.com/home?status='.$tweet);
    }
}
