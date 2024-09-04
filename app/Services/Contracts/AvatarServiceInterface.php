<?php

namespace App\Services\Contracts;

use App\Models\Avatar;
use App\Models\Contracts\AvatarableInterface;
use Illuminate\Http\UploadedFile;

interface AvatarServiceInterface
{
    public function setAvatar(AvatarableInterface $avatarable, UploadedFile $avatar): void;

    public function updateAvatar(AvatarableInterface $avatarable, ?UploadedFile $avatar): void;

    public function deleteAvatar(AvatarableInterface $avatarable): void;

    public function crop(Avatar $avatar, int $width, int $height): void;

    public function optimize(Avatar $avatar): void;
}