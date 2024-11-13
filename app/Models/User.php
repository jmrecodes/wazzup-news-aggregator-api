<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

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
                    ->orderBy('news_feed_priority', 'desc');
    }

    /**
     * Get the news sources for the user's news feed
     */
    public function newsSources()
    {
        return $this->morphedByMany(NewsSource::class, 'morph', 'news_preferences')
                    ->withPivot('news_feed_priority');
    }

    /**
     * Get the news categories for the user's news feed
     */
    public function newsCategories()
    {
        return $this->morphedByMany(NewsCategory::class, 'morph', 'news_preferences')
                    ->withPivot('news_feed_priority');
    }

    /**
     * Get the news authors for the user's news feed
     */
    public function newsAuthors()
    {
        return $this->morphedByMany(NewsAuthor::class, 'morph', 'news_preferences')
                    ->withPivot('news_feed_priority');
    }

    /**
     * Get the articles for the user's news feed
     */
    public function articles(): Collection
    {
        $preferences = $this->preferences;
        $allArticles = collect();

        // Do 10 iterations
        for ($iteration = 0; $iteration < 10; $iteration++) {
            // For each preference ordered by priority
            foreach ($preferences as $preference) {
                $type = $preference->morph_type;
                $id = $preference->morph_id;

                $articles = collect();

                // Get 3 articles with offset based on iteration
                switch ($type) {
                    case 'App\Models\NewsSource':
                        $newsSource = NewsSource::find($id)->source;
                        $articles = Article::select('id', 'title', 'content', 'created_at', 'updated_at')
                            ->where('source', 'like', "%$newsSource%")
                            ->limit(3)
                            ->offset($iteration * 3)
                            ->get();
                        break;
                    case 'App\Models\NewsCategory':
                        $newsCategory = NewsCategory::find($id)->category;
                        $articles = Article::select('id', 'title', 'content', 'created_at', 'updated_at')
                            ->where('category', 'like', "%$newsCategory%")
                            ->limit(3)
                            ->offset($iteration * 3)
                            ->get();
                        break;
                    case 'App\Models\NewsAuthor':
                        $newsAuthor = NewsAuthor::find($id);

                        $articles = Article::select('id', 'title', 'content', 'created_at', 'updated_at')
                            ->where('author', 'like', "%$newsAuthor->first_name% $newsAuthor->last_name%")
                            ->limit(3)
                            ->offset($iteration * 3)
                            ->get();
                        break;
                }

                // Add to collection
                $allArticles = $allArticles->concat($articles);
            }
        }

        return $allArticles->unique('id')->values();
    }

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $url = 'https://test.test/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
