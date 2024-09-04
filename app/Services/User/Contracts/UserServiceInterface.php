<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Services\User\DTOs\CreateDTO;
use App\Services\User\DTOs\IndexDTO;
use App\Services\User\DTOs\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function create(CreateDTO $data): array;

    public function show(string $uuid): User;

    public function update(string $uuid, UpdateDTO $data): void;

    public function delete(string $uuid): void;
}