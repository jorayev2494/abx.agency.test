<?php

namespace App\Driver\File;

use App\Driver\File\Contracts\FileSystemInterface;
use App\Models\Base\Image as BaseImage;
use App\Models\Factories\FileFactory;
use App\Models\Factories\FileType;
use App\Models\Avatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Driver\File\Contracts\PathInterface;

class FileSystem implements FileSystemInterface
{
    private const RANDOM_NAME_LENGTH = 32;

    public function uploadFile(FileType $fileType, UploadedFile $uploadedFile): BaseImage
    {
        $data = [];

        try {
            $data['type'] = $fileType->value;
            $data['path'] = $fileType->getPath();
            $bucketPath = '/' . env('AWS_BUCKET');
            list($data['width'], $data['height']) = @getimagesize($uploadedFile->getPathname());
            $data['mime_type'] = $uploadedFile->getClientMimeType();
            $data['extension'] = $uploadedFile->getClientOriginalExtension();
            $data['size'] = $uploadedFile->getSize();
            $data['file_name'] = $data['name'] = $this->generateFileName($data['extension']);
            $data['file_original_name'] = $uploadedFile->getClientOriginalName();
            $data['full_path'] = '/' . $r = $uploadedFile->storeAs($data['path'], $data['file_name']);
            $data['disk'] = Storage::getDefaultDriver();
            $data['url'] = Storage::url($data['full_path']);

            return FileFactory::make($fileType, $data);
        } catch (\Throwable $th) {
            throw new BadRequestException($th->getMessage());
        }
    }

    public function updateFile(FileType $fileType, ?BaseImage $oldFile, ?UploadedFile $uploadedFile): ?BaseImage
    {
        if (is_null($uploadedFile)) {
            return null;
        }

        $this->deleteFile($oldFile);

        return $this->uploadFile($fileType, $uploadedFile);
    }

    private function generateFileName(string $extension): string
    {
        return Str::random(self::RANDOM_NAME_LENGTH) . '.' . $extension;
    }

    public function deleteFile(?PathInterface $file): bool
    {
        if ($file === null) {
            return true;
        }

        if (Storage::fileExists($fileFullPath = $file->getFullPath())) {
            return Storage::delete($fileFullPath);
        }

        return true;
    }

    protected function deleteDir(string $path): bool
    {
        if (Storage::exists($path)) {
            Storage::deleteDirectory($path);

            return true;
        }

        return false;
    }
}