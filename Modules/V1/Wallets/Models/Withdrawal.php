<?php

namespace Modules\V1\Wallets\Models;

use Carbon\Carbon;
use Database\Factories\WithdrawalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\V1\Wallets\Enums\WithdrawalStatus;
use Ramsey\Uuid\Uuid;

/**
 * @property string                  $id
 * @property string                  $user_id
 * @property string                  $wallet_id
 * @property string                  $from_sheba_number
 * @property string                  $to_sheba_number
 * @property int                     $amount
 * @property ?string                 $note
 * @property WithdrawalStatus|string $status
 * @property ?Carbon                 $confirmed_at
 * @property ?Carbon                 $canceled_at
 * @property ?Carbon                 $created_at
 * @property Wallet                  $wallet
 */
class Withdrawal extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected array $dates = [
        'created_at',
        'confirmed_at',
        'canceled_at',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'wallet_id',
        'from_sheba_number',
        'to_sheba_number',
        'amount',
        'status',
        'confirmed_at',
        'canceled_at',
    ];

    protected static function newFactory(): WithdrawalFactory
    {
        return WithdrawalFactory::new();
    }

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
