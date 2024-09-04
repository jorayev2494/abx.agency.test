<?php

declare(strict_types=1);

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

abstract class JwtAuthModel extends Authenticatable implements JWTSubject
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}