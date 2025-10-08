<?php

namespace App\Providers;

use App\Interfaces\ArticleInterface;
use App\Repositories\ArticleRepository;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ArticleInterface::class, ArticleRepository::class);
    }

    public function boot(): void
    {
        // 
    }
}