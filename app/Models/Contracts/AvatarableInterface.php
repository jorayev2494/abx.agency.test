<?php

namespace App\Models\Contracts;

use App\Models\Avatar;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface AvatarableInterface
{
    public function getAvatar(): ?Avatar;

    public function avatar(): HasOne;
}