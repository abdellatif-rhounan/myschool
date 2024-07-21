<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(12345678),
            'user_type' => fake()->randomElement([1, 2, 3, 4]),
            'status' => fake()->randomElement([0, 1]),
            'created_by' => 1,
        ];
    }
}
