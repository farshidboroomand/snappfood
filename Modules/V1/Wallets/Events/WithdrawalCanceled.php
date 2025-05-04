<?php

namespace Modules\V1\Wallets\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\V1\Wallets\Models\Withdrawal;

class WithdrawalCanceled
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly Withdrawal $withdrawal) {}
}
