<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(1234),
            'status' => fake()->randomElement([0, 1]),
            'created_by' => fake()->randomElement([1, 2, 3]),
        ];
    }
}
