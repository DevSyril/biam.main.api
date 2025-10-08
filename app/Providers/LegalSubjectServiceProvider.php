<?php

namespace App\Providers;

use App\Interfaces\LegalSubjectInterface;
use App\Repositories\LegalSubjectRepository;
use Illuminate\Support\ServiceProvider;

class LegalSubjectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LegalSubjectInterface::class, LegalSubjectRepository::class);
    }

    public function boot(): void
    {
        // 
    }
}