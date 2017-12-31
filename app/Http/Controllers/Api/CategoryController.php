<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Get all categories.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Category::orderBy('name')->get());
    }

    /**
     * Show random category.
     *
     * @return JsonResponse
     */
    public function random(): JsonResponse
    {
        $category = Category::inRandomOrder()->first();

        return response()->json($category);
    }

    /**
     * Show category detail.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }
}
