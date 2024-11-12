<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsSourceRequest;
use App\Models\NewsSource;
use App\Services\NewsSourceService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="NewsSourceWithUsersData",
 *     title="News Source With Users",
 *     description="News Source model with user relationships",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="source", type="string", example="BBC News"),
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

class NewsSourceController extends Controller
{
    private NewsSourceService $newsSourceService;

    public function __construct(NewsSourceService $newsSourceService)
    {
        $this->newsSourceService = $newsSourceService;
    }

    /**
     * @OA\Get(
     *     path="/api/news-sources",
     *     tags={"News Preferences"},
     *     summary="Get list of news sources",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NewsSource")
     *         )
     *     )
     * )
     */
    public function index(): array
    {
        return $this->newsSourceService->getNewsSources();
    }

    /**
     * @OA\Post(
     *     path="/api/news-sources",
     *     tags={"News Preferences"},
     *     summary="Create a new news source",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"source"},
     *             @OA\Property(property="source", type="string", example="BBC News"),
     *             @OA\Property(property="priority", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="News source created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NewsSourceWithUsersData")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(NewsSourceRequest $request)
    {
        $created = $this->newsSourceService->createNewsSource($request->all());

        return response()->json($created, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/news-sources/{news_source}",
     *     tags={"News Preferences"},
     *     summary="Get specific news source details",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_source",
     *         in="path",
     *         required=true,
     *         description="News Source ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsSource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News source not found"
     *     )
     * )
     */
    public function show(NewsSource $newsSource)
    {
        return $this->newsSourceService->getNewsSource($newsSource);
    }

    /**
     * @OA\Put(
     *     path="/api/news-sources/{news_source}",
     *     tags={"News Preferences"},
     *     summary="Update an existing news source",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_source",
     *         in="path",
     *         required=true,
     *         description="News Source ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News source updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NewsSource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News source not found"
     *     )
     * )
     */
    public function update(Request $request, NewsSource $newsSource)
    {
        $updated = $this->newsSourceService->updateNewsSource($request->all(), $newsSource);

        return response()->json($updated);
    }

    /**
     * @OA\Delete(
     *     path="/api/news-sources/{news_source}",
     *     tags={"News Preferences"},
     *     summary="Delete a news source",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_source",
     *         in="path",
     *         required=true,
     *         description="News Source ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="News source deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News source not found"
     *     )
     * )
     */
    public function destroy(NewsSource $newsSource)
    {
        $this->newsSourceService->deleteNewsSource($newsSource);

        return response()->json(null, 204);
    }
}
