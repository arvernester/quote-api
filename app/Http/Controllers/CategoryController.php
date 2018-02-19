<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Category;
use Carbon\Carbon;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $week = Carbon::now()->addWeek(1);

        $categories = Cache::remember('category.index', $week, function () {
            return Category::orderBy('name')
                ->whereHas('quotes')
                ->withCount('quotes')
                ->get();
        });

        return view('category.index', compact('categories'))
            ->withTitle(__('Category'));
    }
}
