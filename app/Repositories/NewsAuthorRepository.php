<?php

namespace App\Repositories;

use App\NewsAuthorRepositoryInterface;
use App\Models\NewsAuthor;
use App\Models\User;
use Illuminate\Support\Collection;

class NewsAuthorRepository extends BaseRepository implements NewsAuthorRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsAuthor();
    }

    public function create(array $data): NewsAuthor
    {
        $newAuthor = NewsAuthor::create($data);

        // Attach news author to current user's preferences
        $user = User::find(auth()->id());

        $user->newsAuthors()->attach($newAuthor->id, ['news_feed_priority' => 1]);

        $newAuthor = NewsAuthor::select('id', 'first_name', 'last_name')
            ->find($newAuthor->id)
            ->with('users')
            ->first();

        return $newAuthor;
    }

    public function all(): Collection
    {
        return NewsAuthor::select('id', 'first_name', 'last_name')->get()->toArray();
    }

    public function find(NewsAuthor $news_author): NewsAuthor
    {
        return $news_author;
    }

    public function update(array $data, NewsAuthor $news_author): NewsAuthor
    {
        $newsAuthor = $this->find($news_author);
        $newsAuthor->update($data);

        return $news_author;
    }

    public function delete(NewsAuthor $news_author): bool
    {
        return $news_author->delete();
    }
}
