<?php

declare(strict_types=1);

namespace App\Extensions\Auth;

use App\Models\Token;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class TokenAuthProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, #[\SensitiveParameter] array $credentials): bool
    {
        if (! $user instanceof Token) {
            return false;
        }

        if (empty($user->getAuthPassword())) {
            return false;
        }

        return request()->header('user-agent') === $user->getAuthPassword();
    }
}