<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Token;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\TokenRepositoryInterface;

class TokenRepository extends BaseModelRepository implements TokenRepositoryInterface
{
    public function getModelClassName(): string
    {
        return Token::class;
    }

    public function updateOrCreate(Token $token): Token
    {
        return $this->newModelQuery()->updateOrCreate(
            [
                'user_agent' => $token->user_agent,
                'ip' => $token->ip,
            ],
            [
                'user_agent' => $token->user_agent,
                'ip' => $token->ip,
            ]
        );
    }

    public function save(Token $token): bool
    {
        return $token->save();
    }

    public function delete(Token $token): bool
    {
        return $token->delete();
    }
}