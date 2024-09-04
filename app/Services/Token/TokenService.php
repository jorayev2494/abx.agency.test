<?php

declare(strict_types=1);

namespace App\Services\Token;

use App\Http\Resources\Api\UserResource;
use App\Models\Token;
use App\Models\User;
use App\Repositories\Contracts\TokenRepositoryInterface;
use App\Services\Token\Contracts\TokenServiceInterface;
use App\Services\Token\DTOs\GenerateDTO;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class TokenService implements TokenServiceInterface
{
    public function __construct(
        private TokenRepositoryInterface $repository
    ) { }

    public function generate(GenerateDTO $data): array
    {
        $token =  Token::factory()->make($data->toArray());
        $this->repository->updateOrCreate($token);

        /** @var string|bool $token */
        if (! ($token = Auth::attempt($data->toArray()))) {
            throw new BadRequestHttpException('Invalid credentials.');
        }

        return $this->makeResponse($token);
    }

    private function makeResponse(string $token): array
    {
        return compact('token');
    }
}