<?php

declare(strict_types=1);

namespace App\Models\Factories;

use App\Models\Base\Image as BaseImage;
use App\Models\Avatar;

class FileFactory
{
    public static function make(FileType $type, array $attributes): BaseImage
    {
        return match ($type) {
            FileType::AVATAR => Avatar::query()->make($attributes),
        };
    }
}