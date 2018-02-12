<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Quote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Language;

class IndexController extends Controller
{
    public function __invoke(Request $request): View
    {
        $tommorow = Carbon::now()->addDay(1);

        $today = Cache::remember('quote.day', $tommorow, function () {
            return Quote::inRandomOrder()
                ->whereRaw('LENGTH(text) >= 250')
                ->with('author')
                ->take(1)
                ->first();
        });

        $shareTodayQuote = sprintf(
            '%s By %s. Via @%s.',
            $today->text,
            $today->author->name,
            env('TWITTER_USERNAME')
        );

        $random = Quote::inRandomOrder()
            ->with('category', 'author', 'language')
            ->take(1)
            ->first();

        $shareRandomQuote = sprintf(
            '%s By %s. Via @%s.',
            $random->text,
            $random->author->name,
            env('TWITTER_USERNAME')
        );

        if (session('lang') and (session('lang') != $random->language->code_alternate)) {
            $language = Language::whereCodeAlternate(session('lang'))->first();
        }

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author')
            ->paginate(10);

        return view('index', compact(
            'today',
            'random',
            'quotes',
            'language',
            'shareRandomQuote',
            'shareTodayQuote'
        ))
            ->withTitle(sprintf('%s - %s',
                config('app.name'),
                __('Motivational & Inspirational Quotes')
        ));
    }
}
