<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuoteRequest;
use Illuminate\Support\Facades\Auth;

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
            ->with('category', 'language')
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
            ->with('category', 'language')
            ->take($request->limit ?? 20)
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

    /**
     * Return all quotes separated by pagination.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('category')
            ->paginate($request->get('limit', 30));

        $quotes->appends($request->only('limit'));

        return response()->json($quotes);
    }

    /**
     * Store new quote into database.
     *
     * @param QuoteRequest $request
     *
     * @return JsonResponse
     */
    public function store(QuoteRequest $request): JsonResponse
    {
        $quote = Quote::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category,
            'text' => $request->text,
            'author' => $request->author ?? 'Anonymous',
        ]);

        $quote->load('category');

        return response()->json($quote);
    }
}
