<?php

namespace Database\Seeders;

use App\Models\Tutor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    public function run(): void
    {
        Tutor::create([
            'name' => 'Parent',
            'email' => 'parent@gmail.com',
            'password' => Hash::make(1234),
            'status' => 1,
            'created_by' => 1,
        ]);

        Tutor::factory(20)->create();
    }
}
