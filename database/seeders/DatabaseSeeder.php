<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FrameSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            TutorSeeder::class,
            // ClasseSeeder::class,
            // SubjectSeeder::class,
        ]);
    }
}
