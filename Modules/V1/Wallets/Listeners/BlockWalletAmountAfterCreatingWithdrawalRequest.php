<?php

namespace Modules\V1\Wallets\Listeners;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\V1\Wallets\Events\WithdrawalCreated;
use Modules\V1\Wallets\Models\Wallet;

class BlockWalletAmountAfterCreatingWithdrawalRequest implements ShouldQueue
{
    public int $tries = 3;

    public string $queue = 'listeners';

    /**
     * Handle the event.
     */
    public function handle(WithdrawalCreated $event): void
    {
        try {
            DB::transaction(static function () use ($event) {
                Wallet::query()
                      ->where('id', $event->withdrawal->wallet_id)
                      ->where('user_id', $event->withdrawal->user_id)
                      ->lockForUpdate()
                      ->update([
                          'blocked_amount'    => DB::raw("blocked_amount + {$event->withdrawal->amount}"),
                          'available_balance' => DB::raw("available_balance - {$event->withdrawal->amount}"),
                      ]);
            });
        } catch (Exception $ex) {
            Log::error(__('wallets.update_wallet_failed'), [
                'user_id' => $event->withdrawal->user_id,
                'error'   => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Calculate the number of seconds to wait before retrying the queued listener.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [1, 5, 10];
    }
}
