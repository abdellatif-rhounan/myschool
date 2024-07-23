<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            [
                'name' => '1st Class',
                'status' => '1',
                'created_by' => 1,
            ],
            [
                'name' => '2nd Class',
                'status' => '1',
                'created_by' => 1,
            ],
            [
                'name' => '3rd Class',
                'status' => '1',
                'created_by' => 1,
            ],
            [
                'name' => '4th Class',
                'status' => '1',
                'created_by' => 2,
            ],
            [
                'name' => '5th Class',
                'status' => '1',
                'created_by' => 2,
            ],
            [
                'name' => '6th Class',
                'status' => '1',
                'created_by' => 2,
            ],
            [
                'name' => '7th Class',
                'status' => '0',
                'created_by' => 1,
            ],
        ];

        foreach ($classes as $class) {
            Classe::create($class);
        }
    }
}
