<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuoteRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
            'language_id' => $request->language,
            'text' => $request->text,
            'author' => $request->author ?? 'Anonymous',
        ]);

        $quote->load('category');

        return response()->json($quote);
    }

    /**
     * Get single quote of the day from randon category.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function quoteOfTheDay(Request $request): JsonResponse
    {
        $tommorow = Carbon::now()->addDay(1);
        $quote = Cache::remember('quote.oftheday', $tommorow, function () use ($request) {
            return Quote::whereHas('category', function ($category) use ($request) {
                return $category->whereName($request->category);
            })
                ->inRandomOrder()
                ->with('category', 'language')
                ->take(1)
                ->first();
        });

        return response()->json($quote);
    }

    /**
     * Get quote where author has picture.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function author(Request $request): JsonResponse
    {
        $quotes = Quote::orderBy('created_at')
            ->whereHas('author', function ($author) {
                return $author->where('image_path', '!=', null);
            })
            ->take($request->limit ?? 5)
            ->get();

        return response()->json($quotes);
    }

    public function category(Request $request): JsonResponse
    {
        $quotes = Quote::inRandomOrder()
            ->take(6)
            ->whereRaw('CHAR_LENGTH(text) <= 150')
            ->paginate($request->limit ?? 6);

        return response()->json($quotes);
    }
}
