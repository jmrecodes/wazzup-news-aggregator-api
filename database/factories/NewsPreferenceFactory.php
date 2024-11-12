<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\NewsSource;

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
}
