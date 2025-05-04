<?php

namespace Modules\V1\Users\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Users\Events\UserCreated;
use Modules\V1\Users\Listeners\CreateUserProfile;
use Modules\V1\Users\Models\User;
use Tests\TestCase;

class CreateUserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener_creates_user_profile_when_user_is_created(): void
    {
        // Arrange
        $user = User::factory()->make();
        /** @var User $user */
        $user->save();

        // Act
        $event = new UserCreated($user);
        $listener = new CreateUserProfile();
        $listener->handle($event);

        // Assert
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id
        ]);
    }
}
