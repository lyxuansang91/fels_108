<?php

namespace App\Repositories\Eloquents;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Repositories\UserRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\UserRepository(\App\Models\User::class);
        });

        $this->app->bind('App\Repositories\WordRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\WordRepository(\App\Models\Word::class);
        });

        $this->app->bind('App\Repositories\CategoryRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\CategoryRepository(\App\Models\Category::class);
        });
    }
}