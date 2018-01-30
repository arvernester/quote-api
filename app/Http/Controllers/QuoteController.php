<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\View\View;
use App\Language;

class QuoteController extends Controller
{
    public function show($lang, Quote $quote): View
    {
        $quote->load('author', 'category', 'language');

        if (session('lang') and (session('lang') != $quote->language->code_alternate)) {
            $language = Language::whereCodeAlternate(session('lang'))->first();
        }

        return view('quote.show', compact('quote', 'language'))
            ->withTitle(__('Quote by :author', ['author' => $quote->author->name]));
    }
}
