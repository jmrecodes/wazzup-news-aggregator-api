<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
