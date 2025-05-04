<?php

namespace Modules\V1\Wallets\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Users\Models\User;
use Modules\V1\Wallets\Models\Wallet;
use Tests\TestCase;

final class WithdrawalApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_withdrawal_request_can_be_created(): void
    {
        // Arrange
        User::factory()->create();
        $wallet = Wallet::query()->first();
        $wallet->available_balance = 150000;
        $wallet->save();

        // Act
        $payload = [
            'price'             => 100000,
            'from_sheba_number' => 'IR0000484068623094074275',
            'to_sheba_number'   => 'IR0000484068623094074276',
            'note'              => 'nothing else matters'
        ];

        $response = $this->postJson(route('withdrawal.create', [
            'wallet_id' => $wallet->id
        ]), $payload);
        // Assert
        $response->assertOk()
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                            'id',
                            'amount',
                            'from_sheba_number',
                            'to_sheba_number',
                            'note',
                            'status',
                            'created_at',
                         ],
                 ]);
    }

    public function test_if_same_sheba_numbers_are_limited(): void
    {
        // Arrange
        User::factory()->create();
        $wallet = Wallet::query()->first();
        $wallet->available_balance = 150000;
        $wallet->save();

        // Act
        $payload = [
            'price'             => 100000,
            'from_sheba_number' => 'IR0000484068623094074275',
            'to_sheba_number'   => 'IR0000484068623094074275',
        ];

        $response = $this->postJson(route('withdrawal.create', [
            'wallet_id' => $wallet->id
        ]), $payload);
        // Assert
        $response->assertBadRequest()->assertJsonStructure([
            'message',
            'code',
        ]);
    }
}
