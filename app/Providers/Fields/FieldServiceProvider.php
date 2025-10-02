<?php

namespace App\Providers\Fields;

use App\Interfaces\FieldInterface;
use App\Repositories\FieldRepository;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FieldInterface::class, FieldRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
