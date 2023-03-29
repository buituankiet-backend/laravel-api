<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->singleton(
            // Post
            \App\Repositories\Post\PostRepositoryInterface::class,
            \App\Repositories\Post\PostRepository::class,
        );

        $this->app->singleton(
            // User
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class,
        );

        $this->app->singleton(
            // Comment
            \App\Repositories\Comment\CommentRepositoryInterface::class,
            \App\Repositories\Comment\CommentRepository::class,
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
