<?php

namespace App\Models;

use App\Models\Contracts\AvatarableInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

/**
 * 
 *
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 * @property string $first_name
 * @property string $last_name
 * @property-read string $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @property-read \App\Models\Avatar|null $avatar
 * @property int $position_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePositionId($value)
 * @property-read \App\Models\Position $position
 * @property string $phone
 * @property string|null $token_uuid
 * @property-read \App\Models\Token|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTokenUuid($value)
 * @mixin \Eloquent
 */
class User extends Model implements AvatarableInterface
{
    use HasFactory, Notifiable, HasUuids;

    /** @see https://docs.webitel.com/display/WKB/Regex+for+international+phone+number */
    public const PHONE_NUMBER_REGEX = '/^\+?3?8?(0\d{9})$/';

    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // protected $perPage = 6; // We can set pagination per-page

    public function fullName(): Attribute
    {
        return new Attribute(
            get: function (): ?string {
                $fullName = trim(sprintf('%s %s', $this->getAttribute('first_name'), $this->getAttribute('last_name')));

                return ! empty($fullName) ? $fullName : null;
            }
        );
    }

    public function password(): Attribute
    {
        return new Attribute(
            set: static fn (string $value): string => bcrypt($value),
        );
    }

    public function getAvatar(): ?Avatar
    {
        return $this->getAttribute('avatar');
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(Avatar::class, 'owner_uuid', 'uuid');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Token::class, 'token_uuid', 'uuid');
    }
}
