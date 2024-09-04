<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    public array $singletons = [
        \App\Services\Media\Images\Contracts\ImageManagerServiceInterface::class => \App\Services\Media\Images\ImageManagerService::class,
        \App\Services\Media\Images\Contracts\ImageOptimizeServiceInterface::class => \App\Services\Media\Images\ImageOptimizeService::class,

        // Auth
        \App\Services\Token\Contracts\TokenServiceInterface::class => \App\Services\Token\TokenService::class,

        // User
        \App\Services\User\Contracts\UserServiceInterface::class => \App\Services\User\UserService::class,
        \App\Services\Contracts\AvatarServiceInterface::class => \App\Services\AvatarService::class,

        // Position
        \App\Services\Position\Contracts\PositionServiceInterface::class => \App\Services\Position\PositionService::class,
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
