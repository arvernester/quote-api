<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Language;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'callback' => 'string|valid_callback',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $languages = Language::orderBy('name', 'ASC')
            ->get();

        return response()
            ->json($languages)
            ->withCallback($request->callback);
    }
}
