<?php

namespace App\Http\Resources\Api\Collection;

use App\Http\Resources\Api\UserResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property-read Arrayable $resource
 */
class UserCollectResource extends ResourceCollection
{
    public $collects = UserResource::class;

    public function toArray(Request $request): array
    {
        return $this->resource->toArray();
    }
}
