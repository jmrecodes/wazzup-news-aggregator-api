<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the preferences for the user's news feed
     */
    public function preferences()
    {
        return $this->hasMany(NewsPreference::class)
                    ->orderBy('news_feed_priority');
    }



    /**
     * Get the news sources for the user's news feed 
     */ 
    public function newsSources()
    {
        return $this->morphedByMany(NewsSource::class, 'morph', 'users_preferences')
                    ->withPivot('news_feed_priority');
    }

    /**
     * Get the news categories for the user's news feed 
     */
    public function newsCategories()
    {
        return $this->morphedByMany(NewsCategory::class, 'morph', 'users_preferences')
                    ->withPivot('news_feed_priority');
    }
}
