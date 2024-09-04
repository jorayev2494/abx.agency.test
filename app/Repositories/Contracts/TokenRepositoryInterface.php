<?php

namespace App\Repositories\Contracts;

use App\Models\Token;

interface TokenRepositoryInterface
{
    public function updateOrCreate(Token $token): Token;

    public function save(Token $token): bool;

    public function delete(Token $token): bool;
}