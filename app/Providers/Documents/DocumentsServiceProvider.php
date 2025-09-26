<?php

namespace App\Providers\Documents;

use App\Interfaces\DocumentsInterface;
use App\Repositories\DocumentsRepository;
use Illuminate\Support\ServiceProvider;

class DocumentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DocumentsInterface::class, DocumentsRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
