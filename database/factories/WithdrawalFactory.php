<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\V1\Users\Models\User;
use Modules\V1\Wallets\Enums\WithdrawalStatus;
use Modules\V1\Wallets\Models\Wallet;
use Modules\V1\Wallets\Models\Withdrawal;

/**
 * @extends Factory<Wallet>
 */
class WithdrawalFactory extends Factory
{
    protected $model = Withdrawal::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $wallet = Wallet::first();

        return [
            'user_id'           => $user->id,
            'wallet_id'         => $wallet->id,
            'from_sheba_number' => 'IR0000314596741760846999',
            'to_sheba_number'   => 'IR0000314596741760846888',
            'amount'            => $this->faker->numberBetween(100000, 1000000),
            'status'            => WithdrawalStatus::PENDING->value,
        ];
    }
}
