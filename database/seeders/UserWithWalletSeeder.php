<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\V1\Users\Models\User;
use Modules\V1\Users\Models\UserProfile;
use Modules\V1\Wallets\Enums\TransactionTypeEnum;
use Modules\V1\Wallets\Models\Wallet;
use Modules\V1\Wallets\Models\WalletTransaction;

class UserWithWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                UserProfile::factory()->create([
                    'user_id' => $user->id,
                ]);
                $amount = round(fake()->numberBetween(1000000, 10000000), -5);

                /** @var Wallet $wallet */
                $wallet = Wallet::factory()->create([
                    'user_id'           => $user->id,
                    'balance'           => $amount,
                    'available_balance' => $amount,
                ]);

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'amount'    => $wallet->available_balance,
                    'type'      => TransactionTypeEnum::INCREASE->value,
                    'note'      => __('wallets.wallet_transaction.initial_amount')
                ]);
            });
    }
}
