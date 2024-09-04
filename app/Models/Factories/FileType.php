<?php

declare(strict_types=1);

namespace App\Models\Factories;

use App\Models\Avatar;

/**
 * @property-read \App\Models\Base\Image $value
 */
enum FileType : string
{
    case AVATAR = Avatar::class;

    public function getPath(): string
    {
        return $this->value::PATH;
    }
}
