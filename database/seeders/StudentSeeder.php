<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make(1234),
            'status' => 1,
            'created_by' => 1,
        ]);

        Student::factory(80)->create();
    }
}
