<?php

declare(strict_types=1);

namespace App\Services\Token\DTOs;

readonly class GenerateDTO
{
    private function __construct(
        public string $userAgent,
        public string $ip
    ) { }

    public static function make(string $userAgent, string $ip): self
    {
        return new self($userAgent, $ip);
    }

    public function toArray(): array
    {
        return [
            'user_agent' => $this->userAgent,
            'ip' => $this->ip,
        ];
    }
}