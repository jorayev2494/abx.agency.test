<?php

declare(strict_types=1);

namespace App\Utils;

use App\Utils\Contracts\ResponseInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response as HttpResponse;

readonly class Response implements ResponseInterface
{
    public function __construct(
        private ResponseFactory $response
    ) { }

    public function success(mixed $data = [], int $status = HttpResponse::HTTP_OK, array $headers = []): HttpJsonResponse
    {
        if ($data instanceof JsonResource) {
            $data = $data->toArray(request());
        }

        return $this->response->json([
                'success' => true,
                ...$data,
            ],
            $status,
            $headers
        );
    }

    public function fail(array $data, int $status, array $headers = []): HttpJsonResponse
    {
        return $this->response->json([
                'success' => false,
                ...$data,
            ],
            $status,
            $headers
        );
    }
}