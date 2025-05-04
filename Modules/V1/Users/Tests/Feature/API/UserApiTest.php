<?php

namespace Modules\V1\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Users\Models\User;
use Tests\TestCase;

final class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_it_can_list_users(): void
    {
        User::factory()->count(3)->create();

        $response = $this->getJson(route('user.list'));
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_if_new_user_can_be_create(): void
    {
        $payload = [
            'first_name' => 'Ozzy',
            'last_name'  => 'Osbourne',
            'email'      => 'ozzy@heavymetal.com',
            'mobile'     => '091240490932',
            'password'   => 'secret123',
        ];

        $response = $this->postJson(route('user.create'), $payload);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'email'  => 'ozzy@heavymetal.com',
            'mobile' => '091240490932',
        ]);
    }
}
