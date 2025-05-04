<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\V1\Users\Models\User;
use Ramsey\Uuid\Uuid;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id'         => Uuid::uuid4()->toString(),
            'first_name' => fake()->firstNameMale(),
            'last_name'  => fake()->lastName(),
            'email'      => fake()->unique()->safeEmail,
            'mobile'     => fake()->unique()->phoneNumber,
            'password'   => Hash::make('password'),
        ];
    }
}
