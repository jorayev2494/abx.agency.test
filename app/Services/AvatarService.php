<?php

declare(strict_types=1);

namespace App\Services;

use App\Driver\File\Contracts\FileSystemInterface;
use App\Models\Avatar;
use App\Models\Contracts\AvatarableInterface;
use App\Models\Factories\FileType;
use App\Services\Contracts\AvatarServiceInterface;
use App\Services\Media\Images\Contracts\ImageManagerServiceInterface;
use App\Services\Media\Images\Contracts\ImageOptimizeServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

readonly class AvatarService implements AvatarServiceInterface
{
    public function __construct(
        private ImageManagerServiceInterface $imageManagerService,
        private ImageOptimizeServiceInterface $imageOptimizeService,
        private FileSystemInterface $fileSystem
    ) { }

    public function setAvatar(AvatarableInterface $avatarable, UploadedFile $avatar): void
    {
        /** @var Avatar $uploadedAvatar */
        $uploadedAvatar = $this->fileSystem->uploadFile(FileType::AVATAR, $avatar);
        $avatarable->avatar()->save($uploadedAvatar);
    }

    public function updateAvatar(AvatarableInterface $avatarable, ?UploadedFile $avatar): void
    {
        if (is_null($avatar)) {
            return;
        }

        /** @var Avatar $uploadedAvatar */
        $uploadedAvatar = $this->fileSystem->updateFile(FileType::AVATAR, $avatarable->getAvatar(), $avatar);

        if (is_null($uploadedAvatar)) {
            return;
        }

        $avatarable->avatar()?->delete();
        $avatarable->avatar()->save($uploadedAvatar);
    }

    public function deleteAvatar(AvatarableInterface $avatarable): void
    {
        $this->fileSystem->deleteFile($avatarable->getAvatar());
        $avatarable->avatar()?->delete();
    }

    public function crop(Avatar $avatar, int $width, int $height): void
    {
        if ($avatar->isCropped()) {
            return;
        }

        $this->imageManagerService->crop($avatar, $width, $height);

        $avatar->update([
            'width' => $width,
            'height' => $height,
            'path' => $path = $this->imageManagerService->makeCroppedPath($avatar->getPath(), $width, $height),
            'full_path' => $fullPath = str_replace($avatar->getPath(), $path, $avatar->getFullPath()),
            'size' => filesize(Storage::path($fullPath)),
            'url' => str_replace($avatar->getPath(), $path, $avatar->getUrl()),
            'url_pattern' => str_replace($avatar->getPath(), $path, $avatar->getUrlPattern()),
            'is_cropped' => true,
        ]);
    }

    public function optimize(Avatar $avatar): void
    {
        if ($avatar->isOptimized()) {
            return;
        }

        $size = $this->imageOptimizeService->optimize($avatar);

        if ($size > 0) {
            $avatar->update([
                'size' => $size,
                'is_optimized' => true,
            ]);
        }
    }
}