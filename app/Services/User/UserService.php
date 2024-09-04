<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\AvatarServiceInterface;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\DTOs\CreateDTO;
use App\Services\User\DTOs\IndexDTO;
use App\Services\User\DTOs\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PositionRepositoryInterface $positionRepository,
        private AvatarServiceInterface $avatarService
    ) { }

    public function index(IndexDTO $data): LengthAwarePaginator
    {
        return $this->repository->paginate($data->perPage);
    }

    public function create(CreateDTO $data): array
    {
        $position = $this->positionRepository->findById($data->positionId);

        $position ?? throw new NotFoundHttpException('Position not found');

        $user = User::factory()->make(
            $this->makeAttributes(
                $data->toArray(),
                ['password' => $this->generatePassword()]
            )
        );
        Auth::user()->users()->save($user);
        $this->avatarService->setAvatar($user, $data->avatar);

        Auth::logout();

        return ['user_uuid' => $user->uuid];
    }

    public function show(string $uuid): User
    {
        $user = $this->repository->findByUuid($uuid);

        $user ?? throw new NotFoundHttpException('User not found');

        return $user;
    }

    public function update(string $uuid, UpdateDTO $data): void
    {
        $position = $this->positionRepository->findById($data->positionId);

        $position ?? throw new NotFoundHttpException('Position not found');

        $user = $this->repository->findByUuid($uuid);

        $user ?? throw new NotFoundHttpException('User not found');

        $user->fill($this->makeAttributes($data->toArray()));
        $this->repository->save($user);
        $this->avatarService->updateAvatar($user, $data->avatar);
        Auth::logout();
    }

    public function delete(string $uuid): void
    {
        $user = $this->repository->findByUuid($uuid);

        $user ?? throw new NotFoundHttpException('User not found');

        $this->avatarService->deleteAvatar($user);
        $this->repository->delete($user);
        Auth::logout();
    }

    private function makeAttributes(array $data, array $additionalArr = []): array
    {
        return [
            ...Arr::except($data, ['avatar']),
            ...$additionalArr,
        ];
    }

    private function generatePassword(): string
    {
        return md5(microtime());
    }
}