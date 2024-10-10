<?php

use App\Models\Frame;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Tutor;

if (!function_exists('rightModel')) {
    function rightModel($user_type)
    {
        $models = [
            'frame' => Frame::class,
            'teacher' => Teacher::class,
            'student' => Student::class,
            'tutor' => Tutor::class
        ];

        return $models[$user_type];
    }
}
