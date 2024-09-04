<?php

declare(strict_types=1);

namespace App\Services\User\DTOs;

use Illuminate\Http\UploadedFile;

readonly class IndexDTO
{
    private function __construct(
        public ?int $perPage
    ) { }

    public static function make(?int $perPage): self
    {
        return new self($perPage);
    }

    public function toArray(): array
    {
        return [
            'per_page' => $this->perPage,
        ];
    }
}