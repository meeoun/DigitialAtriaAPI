<?php

namespace App\Providers;

use App\Repositories\Contracts\IAuthor;
use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IPost;
use App\Repositories\Eloquent\AuthorRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IPost::class, PostRepository::class);
        $this->app->bind(IAuthor::class, AuthorRepository::class);
        $this->app->bind(IComment::class, CommentRepository::class);
    }
}
