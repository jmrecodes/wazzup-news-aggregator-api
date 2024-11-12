<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'source' => $this->faker->company,
            'category' => $this->faker->word,
            'author' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'description' => $this->faker->paragraphs(3, true),
            'content' => $this->faker->sentences(3, true),
            'published_at' => $this->faker->dateTime(),
        ];
    }

    public function newsFeed(): ArticleFactory
    {
        $user = User::first();

        return $this->state(function (array $attributes) use ($user) {
            return [
                'source' => $user->newsSources()->first()->source,
                'category' => $user->newsCategories()->first()->category,
                'author' => $user->newsAuthors()->first()->first_name . ' ' . $user->newsAuthors()->first()->last_name,
            ];
        });
    }
}
