<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'admin',
            'email' => 'admin@test.com',
            'role' => 1,
            'status' => 1,
        ]);

        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'teacher',
            'email' => 'teacher@test.com',
            'role' => 2,
            'status' => 1,
        ]);

        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'student',
            'email' => 'student@test.com',
            'role' => 3,
            'status' => 1,
        ]);

        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'guardian',
            'email' => 'guardian@test.com',
            'role' => 4,
            'status' => 1,
        ]);
    }
}
