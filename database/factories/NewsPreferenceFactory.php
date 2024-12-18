<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\NewsSource;
use App\Models\NewsCategory;
use App\Models\NewsAuthor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsPreference>
 */
class NewsPreferenceFactory extends Factory
{
    /**
     * Define the model's default state, morphing a user to NewsSource.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::first() ?: User::factory(),
            'morph_id' => NewsSource::factory(),
            'morph_type' => NewsSource::class,
            'news_feed_priority' => $this->faker->numberBetween(1, 5),
        ];
    }

    /**
     * Indicate that the preference morph is of NewsSource type.
     */
    public function forNewsSource(NewsSource $source = null): static
    {
        return $this->state(fn (array $attributes) => [
            'morph_id' => $source?->id ?? NewsSource::factory(),
            'morph_type' => NewsSource::class,
        ]);
    }

    /**
     * Indicate that the preference morph is of NewsCategory type.
     */
    public function forNewsCategory(NewsCategory $category = null): static
    {
        return $this->state(fn (array $attributes) => [
            'morph_id' => $category?->id ?? NewsCategory::factory(),
            'morph_type' => NewsCategory::class,
        ]);
    }

    /**
     * Indicate that the preference morph is of NewsAuthor type.
     */
    public function forNewsAuthor(NewsAuthor $author = null): static
    {
        return $this->state(fn (array $attributes) => [
            'morph_id' => $author?->id ?? NewsAuthor::factory(),
            'morph_type' => NewsAuthor::class,
        ]);
    }
}
