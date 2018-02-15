<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Author;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    /**
     * Show single quote in random order.
     *
     * @return JsonResponse
     */
    public function random(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
            'lang' => 'string|max:2|exists:languages,code_alternate',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quote = Quote::inRandomOrder()
            ->with('author', 'category', 'language')
            ->when($request->lang, function ($query) use ($request) {
                return $query->language($request->lang);
            })
            ->first();

        return response()
            ->json($quote)
            ->withCallback($request->callback);
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
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
            'limit' => 'integer|max:20',
            'lang' => 'string|max:2|exists:languages,code_alternate',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author', 'category', 'language')
            ->when($request->lang, function ($query) use ($request) {
                return $query->language($request->lang);
            })
            ->take($request->limit ?? 20)
            ->get();

        return response()
            ->json($quotes)
            ->withCallback($request->callback);
    }

    /**
     * Show quote detail.
     *
     * @param Quote $quote
     *
     * @return JsonResponse
     */
    public function show(Request $request, Quote $quote): JsonResponse
    {
        $validator = Validator::make($request->all(), [
                'callback' => 'string|valid_callback',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quote->load('author', 'language', 'category');

        return response()
            ->json($quote)
            ->withCallback($request->callback);
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
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
            'limit' => 'integer|max:30',
            'lang' => 'string|max:2|exists:languages,code_alternate',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author', 'category', 'language')
            ->when($request->lang, function ($query) use ($request) {
                return $query->language($request->lang);
            })
            ->paginate($request->limit ?? 30);

        $quotes->appends($request->only('limit', 'format', 'lang'));

        return response()
            ->json($quotes)
            ->withCallback($request->callback);
    }
}
