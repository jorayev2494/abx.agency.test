<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $singletons = [
        \App\Repositories\Contracts\TokenRepositoryInterface::class => \App\Repositories\TokenRepository::class,
        \App\Repositories\Contracts\UserRepositoryInterface::class => \App\Repositories\UserRepository::class,
        \App\Repositories\Contracts\PositionRepositoryInterface::class => \App\Repositories\PositionRepository::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
