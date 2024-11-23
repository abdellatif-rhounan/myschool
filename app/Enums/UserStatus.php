<?php

namespace App\Enums;

enum UserStatus: int
{
    case ACTIVE = 1;
    case VACATION = 2;
    case STOPPED = 3;
}
