<?php

namespace Modules\V1\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Users\Models\User;
use Modules\V1\Wallets\Models\Wallet;
use Tests\TestCase;

final class WalletApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_it_can_get_user_wallet(): void
    {
        // Arrange
        User::factory()->count(1)->create();
        $wallet = Wallet::query()->first();

        // Act
        $response = $this->getJson(route('wallet.get', [
            'wallet_id' => $wallet->id
        ]));

        // Assert
        $response->assertOk()
                 ->assertJsonStructure([
                     'data' => [
                         'wallet_id',
                         'user' => [
                            'user_id',
                            'first_name',
                            'last_name',
                            'email',
                         ],
                     ]
                 ]);
    }
}
