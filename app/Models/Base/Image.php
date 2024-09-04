<?php

declare(strict_types=1);

namespace App\Models\Base;

use App\Driver\File\Contracts\FileInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Image extends Model implements FileInterface
{
    use HasFactory;
    use HasUuids;

    public const PATH = '/base/images';

    protected $fillable = [
        'uuid',
        'width',
        'height',
        'path',
        'mime_type',
        'type',
        'extension',
        'size',
        'file_name',
        'file_original_name',
        'name',
        'full_path',
        'url',
        'url_pattern',
        'disk',
        'downloaded_count',
        'is_public',
        'is_active',
        'is_cropped',
        'is_optimized',
    ];

    protected $primaryKey = 'uuid';

    public $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'is_cropped' => 'boolean',
        'is_optimized' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $hidden = [
        'disk',
        'is_public',
    ];

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (self $model): void {
            $model->url_pattern = static::makeUrlPattern($model);
        });
    }

    public function getFileName(): string
    {
        return $this->getAttribute('file_name');
    }

    public function getMimeType(): string
    {
        return $this->getAttribute('mime_type');
    }

    public function getUrl(): string
    {
        return $this->getAttribute('url');
    }

    public function getUrlPattern(): string
    {
        return $this->getAttribute('url_pattern');
    }

    public function getPath(): string
    {
        return static::PATH;
    }

    public function getFullPath(): string
    {
        return $this->getAttribute('full_path');
    }

    public function isCropped(): bool
    {
        return $this->getAttribute('is_cropped');
    }

    public function isOptimized(): bool
    {
        return $this->getAttribute('is_optimized');
    }

    private static function makeUrlPattern(Image $file): string
    {
        $url = match ($file->getMimeType()) {
            default => sprintf('%s/%s', $file->getPath(), $file->getFileName())
        };

        return sprintf('%s%s', "{endpoint}", $url);
    }
}