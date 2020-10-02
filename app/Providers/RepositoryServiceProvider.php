<?php

namespace App\Providers;

use App\Repositories\Contracts\IPost;
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
    }
}
