<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="NewsAuthor",
 *     title="News Author",
 *     description="News Author model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2023-01-01T00:00:00.000000Z")
 * )
 */
class NewsAuthor extends Model
{
    /** @use HasFactory<\Database\Factories\NewsAuthorFactory> */
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];

    public function users()
    {
        return $this->morphToMany(User::class, 'morph', 'news_preferences')
                    ->withPivot('news_feed_priority');
    }
}
