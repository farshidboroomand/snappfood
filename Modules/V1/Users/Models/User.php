<?php

namespace Modules\V1\Users\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile
 * @property string $password
 */
class User extends AuthenticatableUser
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'mobile',
        'first_name',
        'last_name',
        'password',
        'status',
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(static function (self $user) {
            if (! $user->getKey()) {
                $user->id = Uuid::uuid4()->toString();
            }
        });
    }

    public function setPasswordAttribute($value): void
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
