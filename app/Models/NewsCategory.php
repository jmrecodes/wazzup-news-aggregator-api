<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="NewsCategory",
 *     title="News Category",
 *     description="News Category model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="category", type="string", example="Technology"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2023-01-01T00:00:00.000000Z")
 * )
 */
class NewsCategory extends Model
{
    /** @use HasFactory<\Database\Factories\NewsCategoryFactory> */
    use HasFactory;

    protected $fillable = ['category'];

    public function users()
    {
        return $this->morphToMany(User::class, 'morph', 'news_preferences')
                    ->withPivot('news_feed_priority');
    }
}
