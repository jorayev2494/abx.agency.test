<?php

namespace App\Http\Resources\Api\Collection;

use App\Http\Resources\Api\PositionResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property-read Arrayable $resource
 */
class PositionCollectResource extends ResourceCollection
{
    public $collects = PositionResource::class;

    public function toArray(Request $request): array
    {
        return $this->resource->toArray();
    }
}
