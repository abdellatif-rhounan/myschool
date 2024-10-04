<?php

namespace App\Enums;

enum UserType: string
{
    case Frame = 'frame';
    case Teacher = 'teacher';
    case Student = 'student';
    case Tutor = 'tutor';
}
