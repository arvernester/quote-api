<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public function show($lang, Quote $quote): View
    {
        $quote->load('author', 'category');

        return view('quote.show', compact('quote'));
    }
}
