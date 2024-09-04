<?php

namespace App\Services\Media\Images\Contracts;

use App\Models\Base\Image;

interface ImageOptimizeServiceInterface
{
    public function optimize(Image $image): int;
}