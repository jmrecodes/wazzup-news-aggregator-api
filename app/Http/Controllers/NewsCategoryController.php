<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCategoryRequest;
use App\Models\NewsCategory;
use App\Services\NewsCategoryService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="NewsCategoryWithUsersData",
 *     title="News Category With Users",
 *     description="News Category model with user relationships",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="category", type="string", example="Technology"),
 *     @OA\Property(
 *         property="users",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="category", type="string", example="John Doe"),
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
class NewsCategoryController extends Controller
{
    private NewsCategoryService $newsCategoryService;

    public function __construct(NewsCategoryService $newsCategoryService)
    {
        $this->newsCategoryService = $newsCategoryService;
    }

    /**
     * @OA\Get(
     *     path="/api/news-categories",
     *     tags={"News Preferences"},
     *     summary="Get list of news categories",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NewsCategory")
     *         )
     *     )
     * )
     */
    public function index(): array
    {
        return $this->newsCategoryService->getNewsCategories();
    }

    /**
     * @OA\Post(
     *     path="/api/news-categories",
     *     tags={"News Preferences"},
     *     summary="Create a new news category",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category"},
     *             @OA\Property(property="category", type="string", example="Technology"),
     *             @OA\Property(property="priority", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="News category created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NewsCategoryWithUsersData")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(NewsCategoryRequest $request)
    {
        $created = $this->newsCategoryService->createNewsCategory($request->all());

        return response()->json($created, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/news-categories/{news_category}",
     *     tags={"News Preferences"},
     *     summary="Get specific news category details",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_category",
     *         in="path",
     *         required=true,
     *         description="News Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsCategory")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News category not found"
     *     )
     * )
     */
    public function show(NewsCategory $newsCategory)
    {
        return $this->newsCategoryService->getNewsCategory($newsCategory);
    }

    /**
     * @OA\Put(
     *     path="/api/news-categories/{news_category}",
     *     tags={"News Preferences"},
     *     summary="Update an existing news category",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_category",
     *         in="path",
     *         required=true,
     *         description="News Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="category", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News category updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NewsCategory")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News category not found"
     *     )
     * )
     */
    public function update(Request $request, NewsCategory $newsCategory)
    {
        $updated = $this->newsCategoryService->updateNewsCategory($request->all(), $newsCategory);

        return response()->json($updated);
    }

    /**
     * @OA\Delete(
     *     path="/api/news-categories/{news_category}",
     *     tags={"News Preferences"},
     *     summary="Delete a news category",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="news_category",
     *         in="path",
     *         required=true,
     *         description="News Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="News category deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News category not found"
     *     )
     * )
     */
    public function destroy(NewsCategory $newsCategory)
    {
        $this->newsCategoryService->deleteNewsCategory($newsCategory);

        return response()->json(null, 204);
    }
}
