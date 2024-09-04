<?php

namespace App\Observers;

use App\Driver\File\Contracts\FileSystemInterface;
use App\Models\Avatar;
use App\Services\Contracts\AvatarServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class AvatarObserver implements ShouldQueue
{
    private const CROP_WIDTH = 70;

    private const CROP_HEIGHT = 70;

    public string $queue = 'avatars';

    public function __construct(
        public AvatarServiceInterface $userAvatarService,
        private FileSystemInterface $fileSystem
    ) { }

    public function created(Avatar $avatar): void
    {
        $removeAvatar = $avatar->replicateQuietly();
        $this->userAvatarService->crop($avatar->refresh(), self::CROP_WIDTH, self::CROP_HEIGHT);
        $this->userAvatarService->optimize($avatar->refresh());
        $this->fileSystem->deleteFile($removeAvatar);
    }

    public function updated(Avatar $avatar): void
    {
        //
    }

    public function deleted(Avatar $avatar): void
    {
        //
    }

    public function restored(Avatar $avatar): void
    {
        //
    }

    public function forceDeleted(Avatar $avatar): void
    {
        //
    }
}
