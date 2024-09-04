<?php

namespace App\Providers;

use App\Extensions\Auth\TokenAuthProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Auth::provider('token', static fn ($app, array $config): UserProvider => new TokenAuthProvider($app['hash'], $config['model']));
    }
}
