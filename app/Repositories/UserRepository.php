<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends BaseModelRepository implements UserRepositoryInterface
{
    public function getModelClassName(): string
    {
        return User::class;
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return $this->newModelQuery()->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->newModelQuery()->find($uuid);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->newModelQuery()->where('email', $email)->first();
    }

    public function save(User $user): bool
    {
        return $user->save();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}