<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Show single quote in random order.
     *
     * @return JsonResponse
     */
    public function random(): JsonResponse
    {
        $quote = Quote::inRandomOrder()
            ->with('category')
            ->first();

        return response()->json($quote);
    }

    /**
     * Get latest quote from database.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function latest(Request $request): JsonResponse
    {
        $this->validate($request, [
            'limit' => 'integer|max:20',
        ]);

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('category')
            ->take($request->limit ?? 10)
            ->get();

        return response()->json($quotes);
    }

    /**
     * Show quote detail.
     *
     * @param Quote $quote
     *
     * @return JsonResponse
     */
    public function show(Quote $quote): JsonResponse
    {
        $quote->load('category');

        return response()->json($quote);
    }
}
