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
            $quote->text.$quote->text.$quote->text,
            $quote->author->name,
            env('TWITTER_USERNAME')
        );

        if (strlen($tweet) > 280) {
            return redirect(route_lang('index'));
        }

        return redirect('https://twitter.com/home?status='.$tweet);
    }

    public function facebook(Quote $quote)
    {
        $url = sprintf(
            'https://www.facebook.com/dialog/share?app_id=%s&display=page&href=%s&redirect_uri=%s&quote=%s',
            env('FACEBOOK_APP_ID'),
            urlencode(route_lang('quote.show', $quote)),
            urlencode(url()->previous() ?? route_lang('quote.show', $quote)),
            urlencode($quote->text)
        );

        return redirect($url);
    }
}
