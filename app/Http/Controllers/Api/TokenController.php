<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Token\Contracts\TokenServiceInterface;
use App\Services\Token\DTOs\GenerateDTO;
use App\Utils\Contracts\ResponseInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

readonly class TokenController
{
    public function __construct(
        private ResponseInterface $response,
        private TokenServiceInterface $service
    ) { }

    #[OA\Post(
        path: '/api/token',
        summary: 'Get a new token',
        description: <<<HEAD
            ## Method returns a token that is required to register a new user.
                - The token is valid for 40 minutes and can be used for only one request.
                - For the next registration, you will need to get a new one.
        HEAD,
        tags: ['Token'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Generated token',
                content: [
                    new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            properties: [
                                new OA\Property(
                                    property: 'success',
                                    type: 'boolean',
                                    readOnly: true,
                                    example: true,
                                ),
                                new OA\Property(
                                    property: 'access_token',
                                    type: 'string',
                                    example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMTEvYXBpL3Rva2VuIiwiaWF0IjoxNzI1MjkyNjM0LCJleHAiOjE3MjUyOTYyMzQsIm5iZiI6MTcyNTI5MjYzNCwianRpIjoielZsWlpsbVVlV2tob2xQTCIsInN1YiI6IjljZWExOTc1LWQwZTctNGY3MC05MzlmLTczNTRmMjljNDA4NCIsInBydiI6IjA2M2Y3ODI5YjVlNDQxZTY1MzUyM2E3NTAxMDY0OTM3MjQxMzQ5NTgifQ.XIUlSNFACyAAyu_SqA4YUE_B6E3xBuxNKUTMbwQdS4s',
                                ),
                            ],
                        ),
                    ),
                ],
            ),
        ],
    )]
    public function generate(Request $request): JsonResponse
    {
        return $this->response->success(
            $this->service->generate(
                GenerateDTO::make(
                    $request->header('user-agent'),
                    $request->ip(),
                )
            )
        );
    }
}
