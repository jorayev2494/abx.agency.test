<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Utils\Contracts\ResponseInterface;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class Handler
{
    public static function handle(Exceptions $exceptions): void
    {
        /** @var ResponseInterface $response */
        $response = resolve(\App\Utils\Response::class);

        $exceptions->renderable(static function (\Illuminate\Auth\AuthenticationException $ex, Request $request) use($response) {
            if ($request->is('api/*')) {
                return $response->fail([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->renderable(static function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $ex, Request $request) use($response) {
            if ($request->is('api/*')) {
                return $response->fail([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_FORBIDDEN);
            }
        });

        $exceptions->renderable(static function (\Illuminate\Validation\ValidationException $ex, Request $request) use($response) {
            if ($request->is('api/*')) {
                return $response->fail([
                    'message' => 'Validation failed',
                    'fails' => $ex->validator->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $exceptions->renderable(static function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $ex, Request $request) use($response) {
            if ($request->is('api/*')) {
                return $response->fail([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->renderable(static function (\Symfony\Component\HttpKernel\Exception\BadRequestHttpException $ex, Request $request) use($response) {
            if ($request->is('api/*')) {
                return $response->fail([
                    'message' => $ex->getPrevious()?->getMessage() ?? $ex->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }
        });

        $exceptions->renderable(static function (\Exception $ex, Request $request) use($response) {
            if ($request->is('api/*')) {
                return $response->fail([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }
        });
    }
}