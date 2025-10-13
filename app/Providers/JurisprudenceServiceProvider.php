<?php

namespace App\Providers;

use App\Interfaces\JurisprudenceInterface;
use App\Repositories\JurisprudenceRepository;
use Illuminate\Support\ServiceProvider;

class JurisprudenceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(JurisprudenceInterface::class, JurisprudenceRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
