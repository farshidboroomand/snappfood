<?php

namespace Modules\V1\Wallets\Observers;

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
}
