<?php

namespace Database\Seeders;

use App\Models\Frame;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FrameSeeder extends Seeder
{
    public function run(): void
    {
        Frame::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make(1234),
            'status' => 1,
        ]);

        Frame::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(1234),
            'status' => 1,
        ]);

        Frame::factory(10)->create();
    }
}
