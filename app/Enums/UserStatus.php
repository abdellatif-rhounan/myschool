<?php

namespace App\Enums;

enum UserStatus: int
{
    case Active = 1;
    case Vacation = 2;
    case Stopped = 3;
}
