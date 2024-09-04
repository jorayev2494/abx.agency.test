<?php

declare(strict_types=1);

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModelRepository
{
    private Model $model;

    public function __construct()
    {
        $this->initialize();
    }

    abstract public function getModelClassName(): string;

    private function initialize(): void
    {
        $this->model = app($this->getModelClassName());
    }

    protected function newModelQuery(): Builder
    {
        return $this->getModelClone()->newModelQuery();
    }

    protected function getModelClone(): Model
    {
        return clone $this->model;
    }
}