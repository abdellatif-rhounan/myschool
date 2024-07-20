<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'type' => fake()->randomElement(['Theory', 'Practical']),
            'status' => fake()->randomElement([0, 1]),
            'created_by' => fake()->randomElement([1, 84, 184, 189]),
        ];
    }
}
