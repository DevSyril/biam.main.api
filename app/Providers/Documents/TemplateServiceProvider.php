<?php

namespace App\Providers\Documents;

use App\Interfaces\TemplateInterface;
use App\Repositories\TemplateRepository;
use Illuminate\Support\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TemplateInterface::class, TemplateRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
