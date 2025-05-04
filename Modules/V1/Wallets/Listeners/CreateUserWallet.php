<?php

namespace Modules\V1\Wallets\Listeners;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\V1\Users\Events\UserCreated;
use Modules\V1\Wallets\Models\Wallet;

class CreateUserWallet implements ShouldQueue
{
    public int $tries = 3;

    public string $queue = 'listeners';

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        try {
            DB::transaction(static function () use ($event) {
                $wallet = Wallet::lockForUpdate()->firstOrNew([
                    'user_id' => $event->user->id,
                ]);

                $wallet->save();
            });
        } catch (Exception $ex) {
            Log::error(__('wallets.create_wallet_failed'), [
                'user_id' => $event->user->id,
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
