<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Position;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\PositionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PositionRepository extends BaseModelRepository implements PositionRepositoryInterface
{

    public function getModelClassName(): string
    {
        return Position::class;
    }

    public function get(): Collection
    {
        return $this->newModelQuery()->get();
    }

    public function findById(int $id): ?Position
    {
        return $this->newModelQuery()->find($id);
    }

    public function save(Position $position): bool
    {
        return $position->save();
    }
}