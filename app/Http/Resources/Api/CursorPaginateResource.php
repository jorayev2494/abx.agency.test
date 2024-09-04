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
class CursorPaginateResource extends JsonResource
{
    #[OA\Property(
        type: 'boolean',
        readOnly: true,
        example: true,
    )]
    protected string $success;

    #[OA\Property(
        type: 'object',
        readOnly: true,
        // items: new OA\Info(),
    )]
    protected array $data;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'http://127.0.0.1:8011/api/users',
    )]
    protected string $path;

    #[OA\Property(
        type: 'integer',
        readOnly: true,
        example: 6,
    )]
    protected string $per_page;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'eyJ1c2Vycy51dWlkIjoiOWNlN2JmMzctNjczYi00ZTA3LWI0MWUtMjE1N2MyOTI1Njc2Ii',
        nullable: true,
    )]
    protected string $next_cursor;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'http://127.0.0.1:8011/api/users?cursor=eyJ1c2Vycy51dWlkIjoiOWNlN2JmMzctNjczYi00ZTA3LWI0MWUtMjE1N2MyOTI1Njc2Ii',
        nullable: true,
    )]
    protected string $next_page_url;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'http://127.0.0.1:8011/api/users?cursor=eyJ1c2Vycy51dWlkIjoiOWNlN2JmMzctNjczYi00ZTA3LWI0MWUtMjE1N2MyOTI1Njc2Ii',
        nullable: true,
    )]
    protected string $prev_cursor;

    #[OA\Property(
        type: 'string',
        readOnly: true,
        example: 'http://127.0.0.1:8011/api/users?cursor=eyJ1c2Vycy51dWlkIjoiOWNlN2JmMzctNjczYi00ZTA3LWI0MWUtMjE1N2MyOTI1Njc2Ii',
        nullable: true,
    )]
    protected string $prev_page_url;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
