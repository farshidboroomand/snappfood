<?php

namespace Modules\V1\Wallets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\V1\Users\Models\User;
use Modules\V1\Wallets\Enums\Currencies;
use Ramsey\Uuid\Uuid;

/**
 * @property string     $id
 * @property string     $user_id
 * @property int        $balance
 * @property int        $available_balance
 * @property int        $blocked_amount
 * @property Currencies $currency
 * @property User       $user
 */
class Wallet extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'balance',
        'available_balance',
        'blocked_amount',
        'currency',
    ];

    protected static function booted(): void
    {
        static::creating(static function (self $wallet) {
            if (! $wallet->getKey()) {
                $wallet->id = Uuid::uuid4()->toString();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
