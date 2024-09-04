<?php

namespace App\Http\Resources\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property-read Position $position
 */
#[OA\Schema(type: 'object')]
class PositionResource extends JsonResource
{
    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 5
    )]
    protected int $id;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'Designer'
    )]
    protected string $name;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
