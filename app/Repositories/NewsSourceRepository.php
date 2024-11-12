<?php

namespace App\Repositories;

use App\NewsSourceRepositoryInterface;
use App\Models\NewsSource;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewsSourceRepository extends BaseRepository implements NewsSourceRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsSource();
    }

    public function create(array $data): NewsSource
    {
        $newSource = NewsSource::create($data);

        // Attach news source to current user's preferences
        $user = User::find(auth()->id());

        $user->newsSources()->attach($newSource->id, ['news_feed_priority' => 1]);

        $newSource = NewsSource::select('id', 'source')->find($newSource->id)->with('users')->first();

        return $newSource;
    }

    public function all(): array
    {
        return NewsSource::select('id', 'source')->get()->toArray();
    }

    public function find(NewsSource $news_source): NewsSource
    {
        return $news_source;
    }

    public function update(array $data, NewsSource $news_source): NewsSource
    {
        $newsSource = $this->find($news_source);
        $newsSource->update($data);

        return $news_source;
    }

    public function delete(NewsSource $news_source): bool
    {
        return $news_source->delete();
    }
}
