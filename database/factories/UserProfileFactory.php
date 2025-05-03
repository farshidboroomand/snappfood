<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\V1\Users\Models\UserProfile;

/**
 * @extends Factory<UserProfile>
 */
class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    public function definition(): array
    {
        return [
            'sheba_number' => 'IR' . str_pad(fake()->numberBetween(0, 999999999999999999), 22, '0', STR_PAD_LEFT),
        ];
    }
}
