<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\AuthorProfile;

class AuthorProfileController extends Controller
{
    /**
     * Update author profile by column.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateable(Request $request): JsonResponse
    {
        $this->validate($request, [
            'pk' => 'required|integer|exists:author_profiles,id',
            'name' => 'required|string|has_column:author_profiles',
        ]);

        $profile = AuthorProfile::whereId($request->pk)
            ->update([$request->name => $request->value]);

        return response()->json([
                'message' => __('Author profile has been updated.'),
            ]
        );
    }
}
