<?php

namespace App\Providers;

use AB\OAuthTokenValidator\Contracts\UserRepositoryContract;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\Repository as CacheImplementation;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Define which UserRepository implementation should be used
        $this->app->bind(
            UserRepositoryContract::class,
            EloquentUserRepository::class
        );
        $this->app->singleton(CacheImplementation::class, CacheContract::class);
    }
}
