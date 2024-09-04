<?php

declare(strict_types=1);

namespace App\Services\Media\Images;

use App\Driver\File\Contracts\FileInterface;
use App\Services\Media\Images\Contracts\ImageManagerServiceInterface;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

readonly class ImageManagerService implements ImageManagerServiceInterface
{
    public function __construct(
        private ImageManager $imageManager
    ) { }

    public function crop(FileInterface $file, int $width, int $height): Image
    {
        $image = $this->imageManager->read(Storage::path($file->getFullPath()));
        $image->crop($width, $height);
        $croppedPath = $this->makeCroppedPath($file->getPath(), $width, $height);
        $this->checkExistsPath($croppedPath);

        return $this->save($image, $croppedPath, $file->getFileName());
    }

    private function save(Image $image, string $path, string $name): Image
    {
        return $image->save(sprintf('%s/%s', Storage::path($path), $name));
    }

    public function makeCroppedPath(string $path, int $width, int $height): string
    {
        return sprintf('%s/%sx%s', $path, $width, $height);
    }

    private function checkExistsPath(string $path): void
    {
        if (! Storage::exists($path)) {
             Storage::makeDirectory($path);
        }
    }
}