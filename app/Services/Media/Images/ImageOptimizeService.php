<?php

declare(strict_types=1);

namespace App\Services\Media\Images;

use App\Models\Base\Image;
use App\Services\Media\Images\Contracts\ImageOptimizeServiceInterface;
use Illuminate\Support\Facades\Storage;
use Tinify;

readonly class ImageOptimizeService implements ImageOptimizeServiceInterface
{
    public function optimize(Image $image): int
    {
        $source = Tinify\fromFile($path = Storage::path($image->getFullPath()));

        return $source->toFile($path) ?: 0;
    }
}