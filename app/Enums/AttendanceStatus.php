<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case ON_TIME = 'on_time';
    case LATE = 'late';
    case VACATION = 'vacation';
    case ABSENT = 'absent';
}
