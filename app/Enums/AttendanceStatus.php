<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case ON_TIME = 'on_time';
    case LATE = 'late';
    case VACATION = 'vacation';
    case ABSENT = 'absent';

    public function label(): string
    {
        return match ($this) {
            self::ON_TIME => 'On Time',
            self::LATE => 'Late',
            self::VACATION => 'Vacation',
            self::ABSENT => 'Absent'
        };
    }
}
