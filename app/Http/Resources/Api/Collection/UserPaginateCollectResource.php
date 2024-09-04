<?php

namespace App\Http\Resources\Api\Collection;

use App\Extensions\Paginator\CustomPaginator;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * @var CustomPaginator $request
 */
#[OA\Schema(type: 'object')]
class UserPaginateCollectResource extends ResourceCollection
{
    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 1,
    )]
    protected int $page;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 3,
    )]
    protected int $total_pages;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 16,
    )]
    protected int $total_users;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 6,
    )]
    protected int $count;

    #[OA\Property(
        type: 'object',
        readOnly: true,
        example: [
            'prev_url' => null,
            'next_url' => 'http://127.0.0.1:8011/api/users?page=2',
        ],
    )]
    protected array $links;

    public $collects = UserResource::class;

    public function toArray(Request $request): array
    {
        return $this->resource->setDataKey('users')->toArray();
    }
}
