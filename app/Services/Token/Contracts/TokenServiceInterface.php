<?php

declare(strict_types=1);

namespace App\Services\Token\Contracts;

use App\Services\Token\DTOs\GenerateDTO;

interface TokenServiceInterface
{
    public function generate(GenerateDTO $data): array;
}