<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\Collection\PositionCollectResource;
use App\Services\Position\Contracts\PositionServiceInterface;
use App\Utils\Contracts\ResponseInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

readonly class PositionController
{
    public function __construct(
        private ResponseInterface $response,
        private PositionServiceInterface $service
    ) { }

    #[OA\Get(
        path: '/api/positions',
        summary: 'Get user positions',
        tags: ['Positions'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Positions',
                content: [
                    new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'success',
                                    type: 'boolean',
                                    example: true
                                ),
                                new OA\Property(
                                    property: 'positions',
                                    type: 'array',
                                    items: new OA\Items(
                                        ref: '#/components/schemas/PositionResource'
                                    )
                                ),
                            ],
                        )
                    ),
                ]
            )
        ],
    )]
    public function index(): JsonResponse
    {
        return $this->response->success([
            'positions' => PositionCollectResource::make($this->service->get())
        ]);
    }
}
