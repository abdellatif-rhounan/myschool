<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(200)
            ->activeStoppedStatus()
            ->create([
                'role' => 3,
            ]);
    }
}
