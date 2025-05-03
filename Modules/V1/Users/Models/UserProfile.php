<?php

namespace Modules\V1\Users\Models;

use Database\Factories\UserProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @property string $id
 * @property string $user_id
 * @property string $sheba_number
 * @property string $national_id
 */
class UserProfile extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'sheba_number',
        'national_id',
    ];

    protected static function newFactory(): UserProfileFactory
    {
        return UserProfileFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(static function (self $userProfile) {
            if (! $userProfile->getKey()) {
                $userProfile->id = Uuid::uuid4()->toString();
            }
        });
    }
}
