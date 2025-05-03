<?php

namespace Modules\V1\Wallets\Observers;

use Modules\V1\Wallets\Enums\WithdrawalStatus;
use Modules\V1\Wallets\Events\WithdrawalCanceled;
use Modules\V1\Wallets\Events\WithdrawalConfirmed;
use Modules\V1\Wallets\Events\WithdrawalCreated;
use Modules\V1\Wallets\Models\Withdrawal;

class WithdrawalObserver
{
    /**
     * Handle the Withdrawal "created" event.
     */
    public function created(Withdrawal $withdrawal): void
    {
        event(new WithdrawalCreated($withdrawal));
    }

    /**
     * Handle the Withdrawal "created" event.
     */
    public function updated(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status === WithdrawalStatus::CONFIRMED->value) {
            event(new WithdrawalConfirmed($withdrawal));
        }

        if ($withdrawal->status === WithdrawalStatus::CANCELED->value) {
            event(new WithdrawalCanceled($withdrawal));
        }
    }
}
