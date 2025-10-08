<?php

namespace App\Providers;

use App\Interfaces\LegalTextInterface;
use App\Repositories\LegalTextRepository;
use Illuminate\Support\ServiceProvider;

class LegalTextServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LegalTextInterface::class, LegalTextRepository::class);
    }

    public function boot(): void
    {
        // 
    }
}