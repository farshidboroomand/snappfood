<?php

namespace Modules\V1\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Users\Models\User;
use Modules\V1\Users\Models\UserProfile;
use Tests\TestCase;

final class UserProfileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_profile_can_be_updated(): void
    {
        User::factory()
            ->count(1)
            ->create()
            ->each(function ($user) {
                UserProfile::factory()->create([
                    // @phpstan-ignore-next-line
                    'user_id' => $user->id,
                ]);
            });

        $userProfile = UserProfile::query()->first();

        $payload = [
            'sheba_number' => 'IR0000617724434017058207',
            'national_id'  => '0453740707',
        ];

        $response = $this->patchJson(route('user_profile.update', [
            'user_id'    => $userProfile->user_id,
            'profile_id' => $userProfile->id
        ]), $payload);

        $response->assertOk();
        $this->assertDatabaseHas('user_profiles', [
            'sheba_number' => 'IR0000617724434017058207',
            'national_id'  => '0453740707',
        ]);
    }
}
