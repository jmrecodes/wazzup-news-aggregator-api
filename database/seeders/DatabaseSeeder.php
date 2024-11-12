<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\NewsPreference;
use App\Models\NewsSource;
use App\Models\NewsCategory;
use App\Models\NewsAuthor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users if none exist
        if (User::count() === 0) {
            User::factory(10)->create();
        }

        // Create 10 news source NewsPreferences if none exist
        if (NewsSource::count() === 0) {
            NewsPreference::factory(10)
                ->forNewsSource()
                ->create();
        }

        // Create 10 news category NewsPreferences if none exist
        if (NewsCategory::count() === 0) {
            NewsPreference::factory(10)
                ->forNewsCategory()
                ->create();
        }

        // Create 10 news author NewsPreferences if none exist
        if (NewsAuthor::count() === 0) {
            NewsPreference::factory(10)
                ->forNewsAuthor()
                ->create();
        }
    }
}
