<?php

namespace App\Repositories\Contracts;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

interface PositionRepositoryInterface
{
    public function get(): Collection;

    public function findById(int $id): ?Position;

    public function save(Position $position): bool;
}