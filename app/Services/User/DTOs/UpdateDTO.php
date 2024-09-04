<?php

declare(strict_types=1);

namespace App\Services\User\DTOs;

use Illuminate\Http\UploadedFile;

readonly class UpdateDTO
{
    private function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phone,
        public int $positionId,
        public ?UploadedFile $avatar
    ) { }

    public static function make(string $firstName, string $lastName, string $email, string $phone, int $positionId, ?UploadedFile $avatar): self
    {
        return new self($firstName, $lastName, $email, $phone, $positionId, $avatar);
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'position_id' => $this->positionId,
            'avatar' => $this->avatar,
        ];
    }
}