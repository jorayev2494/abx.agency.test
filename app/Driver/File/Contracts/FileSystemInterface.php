<?php

declare(strict_types=1);

namespace App\Driver\File\Contracts;

use App\Models\Base\Image;
use App\Models\Base\Image as BaseImage;
use App\Models\Factories\FileType;
use Illuminate\Http\UploadedFile;

interface FileSystemInterface
{
    public function uploadFile(FileType $fileType, UploadedFile $uploadedFile): Image;

    public function updateFile(FileType $fileType, ?BaseImage $oldFile, ?UploadedFile $uploadedFile): ?BaseImage;

    public function deleteFile(?PathInterface $file): bool;
}