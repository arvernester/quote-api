<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Quote;
use App\Category;
use App\Author;
use App\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $latestQuotes = Quote::orderBy('created_at', 'DESC')
            ->with('category')
            ->take(10)
            ->get();

        $latestAuthors = Author::orderBy('created_at', 'DESC')
            ->with('latestQuote')
            ->take(20)
            ->get();

        return view('admin.dashboard')
            ->with([
                'total' => [
                    'quote' => Quote::count(),
                    'category' => Category::count(),
                    'author' => Author::count(),
                    'user' => User::count(),
                ],
                'latestQuotes' => $latestQuotes,
                'latestAuthors' => $latestAuthors,
            ])
            ->withTitle(__('Dashboard'));
    }
}
