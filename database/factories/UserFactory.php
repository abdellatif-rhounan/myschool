<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'gender' => fake()->randomElement(['male', 'female']),
            'role' => fake()->randomElement([1, 2, 3, 4]),
            'status' => fake()->randomElement([1, 2, 3]),
            'created_by' => 1,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function activeStoppedStatus(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => fake()->randomElement([1, 3]),
        ]);
    }
}
