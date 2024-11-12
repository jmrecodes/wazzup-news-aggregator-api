<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Article",
 *     title="Article",
 *     description="News article model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1,
 *         description="Article ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Breaking News: Major Discovery",
 *         description="Article title"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         example="Article content goes here...",
 *         description="Main content of the article"
 *     ),
 *     @OA\Property(
 *         property="source",
 *         type="string",
 *         example="Reuters",
 *         description="News source name"
 *     ),
 *     @OA\Property(
 *         property="category",
 *         type="string",
 *         example="Technology",
 *         description="Article category"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         type="string",
 *         example="John Doe",
 *         description="Article author"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="datetime",
 *         example="2024-01-01T00:00:00Z",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="datetime",
 *         example="2024-01-01T00:00:00Z",
 *         description="Last update timestamp"
 *     )
 * )
 */
class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'source',
        'category',
        'author',
        'description',
        'content',
        'published_at',
    ];
}
