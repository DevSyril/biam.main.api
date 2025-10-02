<?php

namespace App\Providers\Documents;

use App\Interfaces\TemplateSectionInterface;
use App\Repositories\TemplateSectionRepository;
use Illuminate\Support\ServiceProvider;

class TemplateSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TemplateSectionInterface::class, TemplateSectionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
