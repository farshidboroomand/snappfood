<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\V1\Wallets\Models\Wallet;

/**
 * @extends Factory<Wallet>
 */
class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        $amount = $this->faker->numberBetween(1000000, 10000000);

        return [
            'balance'           => $amount,
            'available_balance' => $amount,
        ];
    }
}
