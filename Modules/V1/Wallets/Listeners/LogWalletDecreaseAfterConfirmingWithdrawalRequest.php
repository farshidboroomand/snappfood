<?php

namespace Modules\V1\Wallets\Listeners;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\V1\Wallets\Enums\TransactionType;
use Modules\V1\Wallets\Events\WithdrawalConfirmed;
use Modules\V1\Wallets\Models\WalletTransaction;

class LogWalletDecreaseAfterConfirmingWithdrawalRequest implements ShouldQueue
{
    public int $tries = 3;

    public string $queue = 'listeners';

    /**
     * Handle the event.
     */
    public function handle(WithdrawalConfirmed $event): void
    {
        try {
            DB::transaction(static function () use ($event) {
                WalletTransaction::create([
                    'wallet_id' => $event->withdrawal->wallet_id,
                    'amount'    => $event->withdrawal->amount,
                    'type'      => TransactionType::DECREASE->value,
                    'note'      => __('wallets.wallet_transaction.amount_decreased')
                ]);
            });
        } catch (Exception $ex) {
            Log::error(__('wallets.wallet_transaction.decrease_failed'), [
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
