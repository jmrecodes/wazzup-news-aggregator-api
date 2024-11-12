<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="NewsSource",
 *     title="News Source",
 *     description="News Source model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="source", type="string", example="CNN"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2023-01-01T00:00:00.000000Z")
 * )
 */
class NewsSource extends Model
{
    /** @use HasFactory<\Database\Factories\NewsSourceFactory> */
    use HasFactory;

    protected $fillable = ['source'];

    public function users()
    {
        return $this->morphToMany(User::class, 'morph', 'news_preferences')
                    ->withPivot('news_feed_priority');
    }
}
