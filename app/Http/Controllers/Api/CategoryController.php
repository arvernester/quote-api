<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categories = Category::orderBy('name')
            ->withCount('quotes')
            ->get();

        return response()
            ->json($categories)
            ->withCallback($request->callback);
    }

    /**
     * Show random category.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function random(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::inRandomOrder()->first();

        return response()
            ->json($category)
            ->withCallback($request->callback);
    }

    /**
     * Show category detail.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function show(Request $request, Category $category): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()
            ->json($category)
            ->withCallback($request->callback);
    }
}
