<?php

namespace Modules\V1\Wallets\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Users\Events\UserCreated;
use Modules\V1\Users\Models\User;
use Modules\V1\Wallets\Listeners\CreateUserWallet;
use Tests\TestCase;

class CreateWalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener_creates_user_wallet_when_user_is_created(): void
    {
        // Arrange
        $user = User::factory()->make();
        /** @var User $user */
        $user->save();

        // Act
        $event = new UserCreated($user);
        $listener = new CreateUserWallet();
        $listener->handle($event);

        // Assert
        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id
        ]);
    }
}
