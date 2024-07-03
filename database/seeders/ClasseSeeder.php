<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        Classe::create([
            'name' => '1st Class',
            'status' => 1,
            'created_by' => 1,
        ]);

        Classe::create([
            'name' => '2nd Class',
            'status' => 1,
            'created_by' => 1,
        ]);

        Classe::create([
            'name' => '3rd Class',
            'status' => 1,
            'created_by' => 1,
        ]);
    }
}
