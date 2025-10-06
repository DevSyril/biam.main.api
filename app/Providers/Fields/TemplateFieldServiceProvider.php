<?php

namespace App\Providers\Fields;

use App\Interfaces\TemplateFieldInterface;
use App\Repositories\TemplateFieldRepository;
use Illuminate\Support\ServiceProvider;

class TemplateFieldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TemplateFieldInterface::class, TemplateFieldRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
