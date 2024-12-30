<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case VERIFICATOR = 'verificator';
    case EMPLOYEE = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::VERIFICATOR => 'Verificator',
            self::EMPLOYEE => 'Employee'
        };
    }
}
