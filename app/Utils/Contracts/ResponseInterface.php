<?php

namespace App\Utils\Contracts;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

interface ResponseInterface
{
    public function success(mixed $data = [], int $status = HttpResponse::HTTP_OK, array $headers = []): HttpJsonResponse;

    public function fail(array $data, int $status, array $headers = []): HttpJsonResponse;
}