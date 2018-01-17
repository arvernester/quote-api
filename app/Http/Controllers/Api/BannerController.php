<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Banner;

class BannerController extends Controller
{
    /**
     * Get latest active banner from database.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function latest(Request $request): JsonResponse
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('created_at', 'DESC')
            ->take($request->limit ?? 5)
            ->get();

        return response()->json($banners);
    }
}
