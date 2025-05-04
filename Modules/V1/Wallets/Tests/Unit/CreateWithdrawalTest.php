<?php

namespace Modules\V1\Wallets\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Wallets\Enums\TransactionType;
use Modules\V1\Wallets\Events\WithdrawalCanceled;
use Modules\V1\Wallets\Events\WithdrawalConfirmed;
use Modules\V1\Wallets\Events\WithdrawalCreated;
use Modules\V1\Wallets\Listeners\BlockWalletAmountAfterCreatingWithdrawalRequest;
use Modules\V1\Wallets\Listeners\LogWalletBlockedAfterCreatingWithdrawalRequest;
use Modules\V1\Wallets\Listeners\LogWalletUnblockedAfterCancelingWithdrawalRequest;
use Modules\V1\Wallets\Listeners\LogWalletUnblockedAfterConfirmingWithdrawalRequest;
use Modules\V1\Wallets\Listeners\UnblockWalletAmountAfterCancelingWithdrawalRequest;
use Modules\V1\Wallets\Listeners\UnblockWalletAmountAfterConfirmingWithdrawalRequest;
use Modules\V1\Wallets\Models\Wallet;
use Modules\V1\Wallets\Models\WalletTransaction;
use Modules\V1\Wallets\Models\Withdrawal;
use Tests\TestCase;

class CreateWithdrawalTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener_block_wallet_amount_in_transaction_when_withdrawal_is_created(): void
    {
        // Arrange
        $withdrawal = $this->createWithdrawal();

        // Act
        $event = new WithdrawalCreated($withdrawal);
        $listener = new BlockWalletAmountAfterCreatingWithdrawalRequest();
        $listener->handle($event);

        $transactions = WalletTransaction::query()
                                         ->where('wallet_id', $withdrawal->wallet_id)
                                         ->where('type', TransactionType::BLOCKED->value)
                                         ->count();
        // Assert
        $this->assertSame(1, $transactions);
    }

    public function test_listener_block_wallet_amount_in_wallets_when_withdrawal_is_created(): void
    {
        // Arrange
        $withdrawal = $this->createWithdrawal();

        // Act
        $event = new WithdrawalCreated($withdrawal);
        $listener = new LogWalletBlockedAfterCreatingWithdrawalRequest();
        $listener->handle($event);
        $walletCount = Wallet::query()
                        ->where('id', $withdrawal->wallet_id)
                        ->where('blocked_amount', $withdrawal->amount)
                        ->count();

        // Assert
        $this->assertSame(1, $walletCount);
    }

    public function test_listener_log_unblock_wallet_amount_in_transactions_when_withdrawal_is_confirmed(): void
    {
        // Arrange
        $withdrawal = $this->createWithdrawal();

        // Act
        $event = new WithdrawalConfirmed($withdrawal);
        $listener = new LogWalletUnblockedAfterConfirmingWithdrawalRequest();
        $listener->handle($event);
        $transactions = WalletTransaction::query()
                                        ->where('wallet_id', $withdrawal->wallet_id)
                                        ->where('type', TransactionType::UNBLOCKED->value)
                                        ->count();
        // Assert
        $this->assertSame(1, $transactions);
    }

    public function test_listener_decrease_wallet_amount_in_wallets_when_withdrawal_is_confirmed(): void
    {
        // Arrange
        $withdrawal = $this->createWithdrawal();

        // Act
        $event = new WithdrawalConfirmed($withdrawal);
        $listener = new UnblockWalletAmountAfterConfirmingWithdrawalRequest();
        $listener->handle($event);
        $walletCount = Wallet::query()
                             ->where('id', $withdrawal->wallet_id)
                             ->where('blocked_amount', '=', 0)
                             ->count();

        // Assert
        $this->assertSame(1, $walletCount);
    }

    public function test_listener_log_unblock_wallet_amount_in_transactions_when_withdrawal_is_canceled(): void
    {
        // Arrange
        $withdrawal = $this->createWithdrawal();

        // Act
        $event = new WithdrawalCanceled($withdrawal);
        $listener = new LogWalletUnblockedAfterCancelingWithdrawalRequest();
        $listener->handle($event);
        $transactions = WalletTransaction::query()
                                         ->where('wallet_id', $withdrawal->wallet_id)
                                         ->where('type', TransactionType::UNBLOCKED->value)
                                         ->count();
        // Assert
        $this->assertSame(1, $transactions);
    }

    public function test_listener_decrease_wallet_amount_in_wallets_when_withdrawal_is_canceled(): void
    {
        // Arrange
        $withdrawal = $this->createWithdrawal();

        // Act
        $event = new WithdrawalCanceled($withdrawal);
        $listener = new UnblockWalletAmountAfterCancelingWithdrawalRequest();
        $listener->handle($event);
        $walletCount = Wallet::query()
                             ->where('id', $withdrawal->wallet_id)
                             ->where('blocked_amount', '=', 0)
                             ->count();

        // Assert
        $this->assertSame(1, $walletCount);
    }

    protected function createWithdrawal(): Withdrawal
    {
        // Arrange
        $withdrawal = Withdrawal::factory()->make();
        /** @var Withdrawal $withdrawal */
        $withdrawal->save();

        return $withdrawal;
    }
}
