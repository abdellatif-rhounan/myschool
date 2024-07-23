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
                'created_by' => 1,
            ],
            [
                'name' => '2nd Class',
                'created_by' => 1,
            ],
            [
                'name' => '3rd Class',
                'created_by' => 1,
            ],
            [
                'name' => '4th Class',
                'created_by' => 2,
            ],
            [
                'name' => '5th Class',
                'created_by' => 2,
            ],
            [
                'name' => '6th Class',
                'created_by' => 2,
            ],
        ];

        foreach ($classes as $class) {
            Classe::create([
                'name' => $class['name'],
                'status' => 1,
                'created_by' => $class['created_by'],
            ]);
        }
    }
}
