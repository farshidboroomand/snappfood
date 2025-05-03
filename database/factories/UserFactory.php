<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\V1\Users\Models\User;
use Ramsey\Uuid\Uuid;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id'         => Uuid::uuid4()->toString(),
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'email'      => $this->faker->unique()->safeEmail,
            'mobile'     => $this->faker->unique()->phoneNumber,
            'password'   => bcrypt('password'),
        ];
    }
}
