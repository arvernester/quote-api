<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Quote;
use App\Category;
use App\Author;
use App\User;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $latestQuotes = Quote::orderBy('created_at', 'DESC')
            ->with('category')
            ->take(10)
            ->get();

        return view('dashboard')
            ->with([
                'total' => [
                    'quote' => Quote::count(),
                    'category' => Category::count(),
                    'author' => Author::count(),
                    'user' => User::count(),
                ],
                'latestQuotes' => $latestQuotes,
            ])
            ->withTitle('Dashboard');
    }
}
