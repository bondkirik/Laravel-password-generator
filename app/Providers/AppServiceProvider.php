<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PasswordGeneratorInterface;
use App\Services\SimplePasswordGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PasswordGeneratorInterface::class, SimplePasswordGenerator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
