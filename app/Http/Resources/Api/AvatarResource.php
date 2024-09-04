<?php

namespace App\Http\Resources\Api;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property-read Avatar $resource
 */
#[OA\Schema()]
class AvatarResource extends JsonResource
{
    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: '9ce82d2d-84b4-475d-845d-5f51b1cae855',
    )]
    protected string $uuid;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 70,
    )]
    protected int $width;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 70,
    )]
    protected int $height;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: '/users/avatars/70x70',
    )]
    protected string $path;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'image/jpeg',
    )]
    protected string $mime_type;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'jpg',
    )]
    protected string $extension;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 949,
    )]
    protected int $size;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'frS7KLXT28k0PL9VPTTUl2SW0RRfUBkd.jpg',
    )]
    protected string $file_name;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'image-15.jpg',
    )]
    protected string $file_original_name;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'frS7KLXT28k0PL9VPTTUl2SW0RRfUBkd.jpg',
    )]
    protected string $name;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: '/users/avatars/70x70/frS7KLXT28k0PL9VPTTUl2SW0RRfUBkd.jpg',
    )]
    protected string $full_path;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'http://localhost:8011/storage/users/avatars/70x70/frS7KLXT28k0PL9VPTTUl2SW0RRfUBkd.jpg',
    )]
    protected string $url;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: '{endpoint}/users/avatars/70x70/frS7KLXT28k0PL9VPTTUl2SW0RRfUBkd.jpg',
    )]
    protected string $url_pattern;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 0,
    )]
    protected int $downloaded_count;

    #[OA\Property(
        type: 'boolean',
        readOnly: true,
        example: true,
    )]
    protected bool $is_active;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: null,
    )]
    protected ?int $deleted_at;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 1725210043,
    )]
    protected int $created_at;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 1725210043,
    )]
    protected int $updated_at;

    #[OA\Property(
        type: 'boolean',
        readOnly: true,
        example: true,
    )]
    protected bool $is_cropped;

    #[OA\Property(
        type: 'boolean',
        readOnly: true,
        example: true,
    )]
    protected bool $is_optimized;

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->resource->uuid,
            'width' => $this->resource->width,
            'height' => $this->resource->height,
            'path' => $this->resource->path,
            'mime_type' => $this->resource->mime_type,
            'extension' => $this->resource->extension,
            'size' => $this->resource->size,
            'file_name' => $this->resource->file_name,
            'file_original_name' => $this->resource->file_original_name,
            'name' => $this->resource->name,
            'full_path' => $this->resource->full_path,
            'url' => $this->resource->url,
            'url_pattern' => $this->resource->url_pattern,
            'downloaded_count' => $this->resource->downloaded_count,
            'is_active' => $this->resource->is_active,
            'deleted_at' => $this->resource->deleted_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'is_cropped' => $this->resource->is_cropped,
            'is_optimized' => $this->resource->is_optimized,
        ];
    }
}
