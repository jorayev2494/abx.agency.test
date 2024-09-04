<?php

namespace App\Http\Resources\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property-read User $resource
 */
#[OA\Schema(type: 'object')]
class UserResource extends JsonResource
{
    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: '9ce6ce09-6db6-4ada-9e2d-ccdbc57ee157',
    )]
    protected string $uuid;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'Jimmy Hermiston',
        nullable: true
    )]
    protected string $full_name;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'Jimmy',
        nullable: true
    )]
    protected string $first_name;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'Hermiston',
        nullable: true
    )]
    protected string $last_name;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'user@example.net',
    )]
    protected string $email;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: '+380956679696',
    )]
    protected string $phone;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'Designer',
    )]
    protected int $position;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 5,
    )]
    protected int $position_id;

    #[OA\Property(
        type: 'object',
        readOnly: true,
        ref: '#/components/schemas/AvatarResource',
        nullable: true,
    )]
    protected ?object $avatar;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 1725302100,
    )]
    protected string $registration_timestamp;

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->resource->uuid,
            'full_name' => $this->resource->full_name,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'position' => $this->resource->position?->name,
            'position_id' => $this->resource->position_id,
            'avatar' => $this->whenLoaded('avatar', AvatarResource::make($this->resource->avatar)),
            'registration_timestamp' => $this->resource->created_at?->getTimestamp(),
        ];
    }
}
