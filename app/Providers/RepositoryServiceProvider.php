<?php
namespace App\Providers;

use App\Repository\Users\UserRepository; 
use App\Repository\Users\UserInterface; 
use App\Repository\Article\ArticleRepository; 
use App\Repository\Article\ArticleInterface; 
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
       $this->app->bind(UserInterface::class, UserRepository::class);
       $this->app->bind(ArticleInterface::class, ArticleRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
