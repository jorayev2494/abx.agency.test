<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Base\Image as BaseImage;
use App\Observers\AvatarObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property string $uuid
 * @property string $owner_uuid
 * @property int|null $width
 * @property int|null $height
 * @property string $path
 * @property string $mime_type
 * @property string $type
 * @property string $extension
 * @property int $size
 * @property string|null $file_name
 * @property string $file_original_name
 * @property string $name
 * @property string $full_path
 * @property string $url
 * @property string $url_pattern
 * @property int $downloaded_count
 * @property string $disk
 * @property bool $is_public
 * @property int $is_active
 * @property string|null $deleted_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @method static \Database\Factories\ImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereDownloadedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereFileOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereFullPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereUrlPattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereWidth($value)
 * @property int $is_cropped
 * @property int $is_optimized
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereIsCropped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereIsOptimized($value)
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Avatar whereOwnerUuid($value)
 * @mixin \Eloquent
 */

#[ObservedBy([AvatarObserver::class])]
class Avatar extends BaseImage
{
    public const PATH = '/users/avatars';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_uuid', 'uuid');
    }
}
