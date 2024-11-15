<?php

namespace App\Enums;

enum Role: int
{
    case ADMIN = 1;
    case TEACHER = 2;
    case STUDENT = 3;
    case GUARDIAN = 4;
}
