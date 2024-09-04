<?php

declare(strict_types=1);

namespace App\Services\Media\Images\Contracts;

use App\Driver\File\Contracts\FileInterface;
use Intervention\Image\Image;

interface ImageManagerServiceInterface
{
    public function crop(FileInterface $file, int $width, int $height): Image;

    public function makeCroppedPath(string $path, int $width, int $height): string;
}