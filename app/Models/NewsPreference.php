<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'morph_id',
        'morph_type',
        'news_feed_priority'
    ];
    
    public function morph()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
