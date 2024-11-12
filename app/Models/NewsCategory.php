<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
