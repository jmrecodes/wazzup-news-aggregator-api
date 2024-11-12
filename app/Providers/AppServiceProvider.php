<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\NewsSourceRepositoryInterface;
use App\Repositories\NewsSourceRepository;
use App\NewsCategoryRepositoryInterface;
use App\Repositories\NewsCategoryRepository;
use App\NewsAuthorRepositoryInterface;
use App\Repositories\NewsAuthorRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->commands([
                \App\Console\Commands\MakeRepository::class,
                \App\Console\Commands\MakeService::class,
            ]);
        }

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NewsSourceRepositoryInterface::class, NewsSourceRepository::class);
        $this->app->bind(NewsCategoryRepositoryInterface::class, NewsCategoryRepository::class);
        $this->app->bind(NewsAuthorRepositoryInterface::class, NewsAuthorRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
