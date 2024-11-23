<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class GuardianSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(100)->create([
            'role' => 4,
        ]);
    }
}
