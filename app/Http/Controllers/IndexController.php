<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Quote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function __invoke(Request $request): View
    {
        $tommorow = Carbon::now()->addDay(1);

        $quote = Cache::remember('quote.day', $tommorow, function () {
            return Quote::inRandomOrder()
                ->whereRaw('LENGTH(text) >= 250')
                ->with('author')
                ->take(1)
                ->first();
        });

        $random = Quote::inRandomOrder()
            ->with('category', 'author')
            ->take(1)
            ->first();

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('index', compact('quote', 'random', 'quotes'));
    }
}
