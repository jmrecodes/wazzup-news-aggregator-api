<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsAuthorRequest;
use App\Models\NewsAuthor;
use App\Services\NewsAuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="NewsAuthorWithUsersData",
 *     title="News Author With Users",
 *     description="News Author model with user relationships",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(
 *         property="users",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *             @OA\Property(
 *                 property="pivot",
 *                 type="object",
 *                 @OA\Property(property="news_feed_priority", type="integer", example=1)
 *             )
 *         )
 *     )
 * )
 */
class NewsAuthorController extends Controller
{
    private NewsAuthorService $newsAuthorService;

    public function __construct(NewsAuthorService $newsAuthorService)
    {
        $this->newsAuthorService = $newsAuthorService;
    }

    /**
     * @OA\Get(
     *     path="/api/authors",
     *     tags={"News Preferences"},
     *     summary="Get list of news authors",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NewsAuthor")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $newsAuthors = $this->newsAuthorService->getNewsAuthors();

        return response()->json($newsAuthors);
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     tags={"News Preferences"},
     *     summary="Create a new news author",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="priority", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="News author created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NewsAuthorWithUsersData")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(NewsAuthorRequest $request): JsonResponse
    {
        $created = $this->newsAuthorService->createNewsAuthor($request->all());

        return response()->json($created, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{news_author}",
     *     tags={"News Preferences"},
     *     summary="Get specific news author details",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_author",
     *         in="path",
     *         required=true,
     *         description="News Author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsAuthor")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News author not found"
     *     )
     * )
     */
    public function show(NewsAuthor $newsAuthor): NewsAuthor
    {
        return $this->newsAuthorService->getNewsAuthor($newsAuthor);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{news_author}",
     *     tags={"News Preferences"},
     *     summary="Update an existing news author",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_author",
     *         in="path",
     *         required=true,
     *         description="News Author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News author updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NewsAuthor")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News author not found"
     *     )
     * )
     */
    public function update(Request $request, NewsAuthor $newsAuthor): JsonResponse
    {
        $updated = $this->newsAuthorService->updateNewsAuthor($request->all(), $newsAuthor);

        return response()->json($updated);
    }

    /**
     * @OA\Delete(
     *     path="/api/authors/{news_author}",
     *     tags={"News Preferences"},
     *     summary="Delete a news author",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_author",
     *         in="path",
     *         required=true,
     *         description="News Author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="News author deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News author not found"
     *     )
     * )
     */
    public function destroy(NewsAuthor $newsAuthor): JsonResponse
    {
        $this->newsAuthorService->deleteNewsAuthor($newsAuthor);

        return response()->json(null, 204);
    }
}
