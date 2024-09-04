<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(?int $perPage): LengthAwarePaginator;

    public function findByUuid(string $uuid): ?User;

    public function findByEmail(string $email): ?User;

    public function save(User $user): bool;

    public function delete(User $user): bool;
}