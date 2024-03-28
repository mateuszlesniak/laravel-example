<?php

namespace App\Providers\Location;

use App\Location\LocationRepository;
use App\Location\LocationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
    }

    public function boot(): void
    {
    }

    private function registerRepositories(): void
    {
        $this->app->bind(LocationRepositoryInterface::class,LocationRepository::class);
    }
}
