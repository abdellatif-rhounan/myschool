<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(30)->create([
            'role' => 2,
        ]);
    }
}
