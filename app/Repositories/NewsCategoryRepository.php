<?php

namespace App\Repositories;

use App\NewsCategoryRepositoryInterface;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Support\Collection;

class NewsCategoryRepository extends BaseRepository implements NewsCategoryRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsCategory();
    }

    public function create(array $data): NewsCategory
    {
        $newCategory = NewsCategory::create($data);

        // Attach news category to current user's preferences
        $user = User::find(auth()->id());

        $user->newsCategories()->attach($newCategory->id, ['news_feed_priority' => 1]);

        $newCategory = NewsCategory::select('id', 'category')
            ->find($newCategory->id)
            ->with('users')
            ->first();

        return $newCategory;
    }

    public function all(): Collection
    {
        return NewsCategory::select('id', 'category')->get();
    }

    public function find(NewsCategory $news_category): NewsCategory
    {
        return $news_category;
    }

    public function update(array $data, NewsCategory $news_category): NewsCategory
    {
        $newsCategory = $this->find($news_category);
        $newsCategory->update($data);

        return $news_category;
    }

    public function delete(NewsCategory $news_category): bool
    {
        return $news_category->delete();
    }
}
