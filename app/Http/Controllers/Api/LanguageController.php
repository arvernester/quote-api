<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Language;

class LanguageController extends Controller
{
    /**
     * Get all registered languages.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $languages = Language::orderBy('name', 'ASC')
            ->get();

        return response()->json($languages);
    }
}
