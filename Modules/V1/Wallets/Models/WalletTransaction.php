<?php

namespace Modules\V1\Wallets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\V1\Wallets\Enums\TransactionTypeEnum;
use Ramsey\Uuid\Uuid;

/**
 * @property string              $id
 * @property string              $wallet_id
 * @property int                 $amount
 * @property TransactionTypeEnum $type
 * @property string              $note
 */
class WalletTransaction extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'note',
    ];

    protected static function booted(): void
    {
        static::creating(static function (self $wallet) {
            if (! $wallet->getKey()) {
                $wallet->id = Uuid::uuid4()->toString();
            }
        });
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
