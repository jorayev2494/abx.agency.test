<?php

declare(strict_types=1);

namespace App\Services\Position;

use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Services\Position\Contracts\PositionServiceInterface;
use Illuminate\Support\Collection;

readonly class PositionService implements PositionServiceInterface
{
    public function __construct(
        private PositionRepositoryInterface $repository
    ) { }

    public function get(): Collection
    {
        return $this->repository->get();
    }
}