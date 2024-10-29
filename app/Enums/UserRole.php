<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case VERIFICATOR = 'verificator';
    case EMPLOYEE = 'employee';
}
