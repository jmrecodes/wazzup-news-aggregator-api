<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsSource extends Model
{
    /** @use HasFactory<\Database\Factories\NewsSourceFactory> */
    use HasFactory;

    protected $fillable = ['source'];

    public function users()
    {
        return $this->morphToMany(User::class, 'morph', 'users_preferences')
                    ->withPivot('news_feed_priority');
    }
}
