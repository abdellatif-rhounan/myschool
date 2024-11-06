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
            'gender' => 'Male',
            'role' => 1,
        ]);

        User::factory(100)->create();
    }
}
