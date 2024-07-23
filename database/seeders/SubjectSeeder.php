<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Math',
                'type' => 'Theory',
                'status' => '1',
                'created_by' => '1'
            ],
            [
                'name' => 'Math Applied',
                'type' => 'Practical',
                'status' => '1',
                'created_by' => '1'
            ],
            [
                'name' => 'Physics',
                'type' => 'Theory',
                'status' => '1',
                'created_by' => '1'
            ],
            [
                'name' => 'Chimics',
                'type' => 'Theory',
                'status' => '1',
                'created_by' => '2'
            ],
            [
                'name' => 'Concentration',
                'type' => 'Practical',
                'status' => '1',
                'created_by' => '2'
            ],
            [
                'name' => 'Self Improvement',
                'type' => 'Practical',
                'status' => '1',
                'created_by' => '2'
            ],
            [
                'name' => 'Debeating',
                'type' => 'Practical',
                'status' => '1',
                'created_by' => '1'
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
