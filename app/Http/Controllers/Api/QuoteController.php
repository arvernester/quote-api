<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Author;

class QuoteController extends Controller
{
    /**
     * Show single quote in random order.
     *
     * @return JsonResponse
     */
    public function random(Request $request): JsonResponse
    {
        $this->validate($request, [
            'lang' => 'string|max:2|exists:languages,code_alternate',
        ]);

        $quote = Quote::inRandomOrder()
            ->with('author', 'category', 'language')
            ->when($request->lang, function ($query) use ($request) {
                return $query->whereHas('language', function ($language) use ($request) {
                    return $language->whereCodeAlternate($request->lang);
                });
            })
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
            'lang' => 'string|max:2|exists:languages,code_alternate',
        ]);

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author', 'category', 'language')
            ->when($request->lang, function ($query) use ($request) {
                return $query->whereHas('language', function ($language) use ($request) {
                    return $language->whereCodeAlternate($request->lang);
                });
            })
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
        $quote->load('author', 'language', 'category');

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
        $this->validate($request, [
            'limit' => 'integer|max:30',
            'lang' => 'string|max:2|exists:languages,code_alternate',
        ]);

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author', 'category', 'language')
            ->when($request->lang, function ($query) use ($request) {
                return $query->whereHas('language', function ($language) use ($request) {
                    return $language->whereCodeAlternate($request->lang);
                });
            })
            ->paginate($request->limit ?? 30);

        $quotes->appends($request->only('limit'));

        return response()->json($quotes);
    }
}
