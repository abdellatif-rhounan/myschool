<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'super',
            'lastname' => 'admin',
            'email' => 'superadmin@test.com',
            'role' => 1,
        ]);

        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'teacher',
            'email' => 'teacher@test.com',
            'role' => 2,
        ]);

        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'student',
            'email' => 'student@test.com',
            'role' => 3,
        ]);

        User::factory()->create([
            'firstname' => 'Mr',
            'lastname' => 'guardian',
            'email' => 'guardian@test.com',
            'role' => 4,
        ]);
    }
}
