<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\User\StoreRequest;
use App\Http\Requests\Api\User\UpdateRequest;
use App\Http\Resources\Api\Collection\UserPaginateCollectResource;
use App\Http\Resources\Api\UserResource;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\DTOs\CreateDTO;
use App\Services\User\DTOs\IndexDTO;
use App\Services\User\DTOs\UpdateDTO;
use App\Utils\Contracts\ResponseInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class UserController implements HasMiddleware
{
    public function __construct(
        private ResponseInterface $response,
        private UserServiceInterface $service
    ) { }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', only: ['store', 'update', 'delete']),
        ];
    }

    #[OA\Get(
        path: '/api/users',
        summary: 'Return a list of users',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    default: 2,
                ),
            ),
            new OA\Parameter(
                name: 'per_page',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    default: 6,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Users Paginate',
                content: [
                    new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'success',
                                    type: 'boolean',
                                    readOnly: true,
                                    example: true,
                                ),
                                new OA\Property(
                                    property: 'users',
                                    type: 'array',
                                    items: new OA\Items(
                                        ref: '#/components/schemas/UserResource'
                                    )
                                ),
                            ],
                            allOf: [new OA\Schema(ref: '#/components/schemas/UserPaginateCollectResource')],
                        )
                    ),
                ]
            )
        ],
    )]
    public function index(Request $request): JsonResponse
    {
        $users = $this->service->index(
            IndexDTO::make(
                (int) $request->query->get('per_page') ?: null
            )
        );

        return $this->response->success(UserPaginateCollectResource::make($users));
    }

    #[OA\Post(
        path: '/api/users',
        summary: 'Register new user',
        security: [
            [
                'bearerAuth' => [],
            ],
        ],
        tags: ['Users'],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: [
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'position_id',
                        'avatar',
                    ],
                    properties: [
                        new OA\Property(
                            description: 'first_name should contain 2 - 60 characters.',
                            property: 'first_name',
                            type: 'string',
                            example: 'Alex',
                            minLength: 2,
                            maxLength: 60,
                        ),
                        new OA\Property(
                            description: 'last_name should contain 2 - 60 characters.',
                            property: 'last_name',
                            type: 'string',
                            example: 'Alexev',
                            minLength: 2,
                            maxLength: 60,
                        ),
                        new OA\Property(
                            description: 'email, must be a valid email according to __RFC2822__.',
                            property: 'email',
                            type: 'string',
                            example: 'alex@gmail.com',
                            uniqueItems: true,
                        ),
                        new OA\Property(
                            description: 'User phone number. Number should start with code of Ukraine __+380__.',
                            property: 'phone',
                            type: 'string',
                            example: '+380956679696',
                        ),
                        new OA\Property(
                            description: 'position_id. You can get list of all positions with their IDs using the API method __GET api/api/positions__.',
                            property: 'position_id',
                            type: 'integer',
                            example: 1,
                        ),
                        new OA\Property(
                            description: 'The avatar format must be jpeg/jpg type. The avatar will be __copped 70x70 and optimized__ in server.',
                            property: 'avatar',
                            type: 'string',
                            format: 'binary',
                        ),
                    ],
                )
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'User created',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                property: 'success',
                                type: 'boolean',
                                readOnly: true,
                                example: true,
                            ),
                            new OA\Property(
                                property: 'user_uuid',
                                type: 'string',
                                readOnly: true,
                                example: '9ce9b7ac-c76b-4006-a0af-85a95673595f',
                            ),
                            new OA\Property(
                                property: 'message',
                                type: 'string',
                                readOnly: true,
                                example: 'New user successfully registered',
                            ),
                        ]
                    )
                )
            ),
        ]
    )]
    public function store(StoreRequest $request): Response
    {
        $result = $this->service->create(
            CreateDTO::make(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('phone'),
                $request->integer('position_id'),
                $request->file('avatar')
            )
        );

        return $this->response->success(
            array_merge(
                $result,
                [
                    'message' => 'New user successfully registered',
                ]
            ),
            Response::HTTP_CREATED
        );
    }

    #[OA\Get(
        path: '/api/users/{uuid}',
        summary: 'Return a user by uuid',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: '9ce7bebe-eacc-4645-94d1-ba23b61975e0')
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Show response',
                content: new OA\MediaType(
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
                                property: 'user',
                                readOnly: true,
                                ref: '#/components/schemas/UserResource',
                            ),
                        ],
                    )
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Not found',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'message',
                                type: 'string',
                                example: 'User not found'
                            )
                        ]
                    )
                )
            ),
        ]
    )]
    public function show(Request $request, string $uuid): JsonResponse
    {
        return $this->response->success([
            'user' => UserResource::make(
                $this->service->show($uuid)
            )->toArray($request)
        ]);
    }

    #[OA\Post(
        path: '/api/users/{uuid}',
        summary: 'Update user',
        security: [
            [
                'bearerAuth' => [],
            ],
        ],
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: '9ce7bebe-eacc-4645-94d1-ba23b61975e0')
            ),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: [
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'position_id',
                        '_method',
                    ],
                    properties: [
                        new OA\Property(
                            description: 'first_name should contain 2 - 60 characters.',
                            property: 'first_name',
                            type: 'string',
                            example: 'Alex',
                            minLength: 2,
                            maxLength: 60,
                        ),
                        new OA\Property(
                            description: 'last_name should contain 2 - 60 characters.',
                            property: 'last_name',
                            type: 'string',
                            example: 'Alexev',
                            minLength: 2,
                            maxLength: 60,
                        ),
                        new OA\Property(
                            description: 'email, must be a valid email according to __RFC2822__.',
                            property: 'email',
                            type: 'string',
                            example: 'alex@gmail.com',
                            uniqueItems: true,
                        ),
                        new OA\Property(
                            description: 'User phone number. Number should start with code of Ukraine __+380__.',
                            property: 'phone',
                            type: 'string',
                            example: '+380956679696',
                        ),
                        new OA\Property(
                            description: 'position_id. You can get list of all positions with their IDs using the API method __GET api/api/positions__.',
                            property: 'position_id',
                            type: 'integer',
                            example: 1,
                        ),
                        new OA\Property(
                            description: 'The avatar format must be jpeg/jpg type. The avatar will be __copped 70x70 and optimized__ in server.',
                            property: 'avatar',
                            type: 'string',
                            format: 'binary',
                        ),
                    ],
                )
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Accepted',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                property: 'success',
                                type: 'boolean',
                                readOnly: true,
                                example: true,
                            ),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Not found',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'message',
                                type: 'string',
                                example: 'User not found'
                            )
                        ]
                    )
                )
            ),
        ]
    )]
    public function update(UpdateRequest $request, string $uuid): Response
    {
        $this->service->update(
            $uuid,
            UpdateDTO::make(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('phone'),
                $request->integer('position_id'),
                $request->file('avatar')
            )
        );

        return $this->response->success(status: Response::HTTP_ACCEPTED);
    }

    #[OA\Delete(
        path: '/api/users/{uuid}',
        summary: 'Delete user',
        security: [
            [
                'bearerAuth' => [],
            ],
        ],
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', example: '9ce7bebe-eacc-4645-94d1-ba23b61975e0')
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: 'No Content',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                property: 'success',
                                type: 'boolean',
                                readOnly: true,
                                example: true,
                            ),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Not found',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                property: 'message',
                                type: 'string',
                                example: 'User not found'
                            )
                        ]
                    )
                )
            ),
        ]
    )]
    public function destroy(string $uuid): Response
    {
        $this->service->delete($uuid);

        return $this->response->success(status: Response::HTTP_NO_CONTENT);
    }
}
