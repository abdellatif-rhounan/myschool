<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678),
            'user_type' => 1,
            'status' => 1,
        ]);

        User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make(12345678),
            'user_type' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make(12345678),
            'user_type' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        User::factory()->create([
            'name' => 'Parent',
            'email' => 'parent@gmail.com',
            'password' => Hash::make(12345678),
            'user_type' => 4,
            'status' => 1,
            'created_by' => 1,
        ]);

        User::factory(200)->create();

        $this->call([
            ClasseSeeder::class,
        ]);
    }
}
