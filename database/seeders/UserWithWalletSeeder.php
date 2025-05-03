<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\V1\Users\Models\User;
use Modules\V1\Wallets\Models\Wallet;

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
                $amount = round(fake()->numberBetween(1000000, 10000000), -5);
                Wallet::factory()->create([
                    'user_id'           => $user->id,
                    'balance'           => $amount,
                    'available_balance' => $amount,
                ]);
            });
    }
}
