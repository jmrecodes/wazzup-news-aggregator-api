<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/news-feed",
     *     summary="Get user's personalized news feed",
     *     description="Retrieves articles based on user's preferences including sources, categories, and authors",
     *     tags={"User"},
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Article")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function newsFeed(Request $request): JsonResponse
    {
        return Cache::remember('news-feed', 1800, function () use ($request) {
            $articles = $this->userService->newsFeed($request->user());

            return response()->json($articles);
        });
    }
}
