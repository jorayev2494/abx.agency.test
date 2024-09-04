<?php

namespace App\Services\Position\Contracts;

use Illuminate\Support\Collection;

interface PositionServiceInterface
{
    public function get(): Collection;
}