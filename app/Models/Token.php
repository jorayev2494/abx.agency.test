<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Base\JwtAuthModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property string $uuid
 * @property string|null $user_agent
 * @property string|null $ip
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Token newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Token query()
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Token withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Token extends JwtAuthModel
{
    use HasFactory, SoftDeletes;

    protected $authPasswordName = 'user_agent';

    protected $fillable = [
        'user_agent',
        'ip',
        'location',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'token_uuid', 'uuid');
    }
}
